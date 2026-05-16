<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\Pago;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PagoController extends Controller
{
    /**
     * Registrar un nuevo pago manual (voucher/boucher).
     */
    public function registrarPago(Request $request, $id)
    {
        $cotizacion = Cotizacion::findOrFail($id);

        $request->validate([
            'monto_pagado' => 'required|numeric|min:0',
            'fecha_deposito' => 'required|date',
            'nro_comprobante' => 'required|string',
            'banco_id' => 'required|exists:bancos,id',
            'boucher' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Validar unicidad compuesta (nro_comprobante + banco_id)
        $existe = Pago::where('nro_comprobante', $request->nro_comprobante)
            ->where('banco_id', $request->banco_id)
            ->exists();

        if ($existe) {
            return response()->json([
                'error' => 'Ya existe un pago registrado con ese número de comprobante para este banco.'
            ], 422);
        }

        return DB::transaction(function () use ($request, $cotizacion) {
            $path = $request->file('boucher')->store('pagos', 'public');

            $pago = Pago::create([
                'monto_pagado' => $request->monto_pagado,
                'fecha_deposito' => $request->fecha_deposito,
                'nro_comprobante' => $request->nro_comprobante,
                'boucher_path' => $path,
                'banco_id' => $request->banco_id,
                'estado' => 'pendiente',
            ]);

            $cotizacion->pagos()->attach($pago->id);

            return response()->json([
                'message' => 'Pago registrado correctamente y pendiente de verificación.',
                'pago' => $pago
            ], 201);
        });
    }

    /**
     * Listar pagos pendientes para tesorería.
     */
    public function pagosPendientes()
    {
        $pagos = Pago::with(['banco', 'cotizaciones'])
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($pagos);
    }

    /**
     * Verificar o rechazar un pago.
     */
    public function verificarPago(Request $request, $id)
    {
        $pago = Pago::with('cotizaciones')->findOrFail($id);

        $request->validate([
            'estado' => 'required|in:verificado,rechazado',
            'motivo_rechazo' => 'required_if:estado,rechazado|nullable|string',
        ]);

        return DB::transaction(function () use ($request, $pago) {
            $oldEstado = $pago->estado;
            
            $pago->update([
                'estado' => $request->estado,
                'verificado_por' => Auth::id() ?? 1,
                'fecha_verificacion' => Carbon::now(),
                'motivo_rechazo' => $request->estado === 'rechazado' ? $request->motivo_rechazo : null,
            ]);

            // Si pasa a verificado, actualizamos los montos totales pagados de las cotizaciones asociadas
            if ($request->estado === 'verificado' && $oldEstado !== 'verificado') {
                foreach ($pago->cotizaciones as $cotizacion) {
                    $totalPagado = $cotizacion->pagos()
                        ->where('estado', 'verificado')
                        ->sum('monto_pagado');
                    
                    $cotizacion->update(['monto_total_pagado' => $totalPagado]);
                }
            }

            return response()->json([
                'message' => "Pago {$request->estado} correctamente.",
                'pago' => $pago
            ]);
        });
    }
}
