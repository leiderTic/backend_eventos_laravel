<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::with(['user', 'evento', 'clientes', 'servicios', 'tarifas.tipoTarifa', 'tarifas.espacio'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($cotizaciones);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_ini',
            'evento_id' => 'required|exists:eventos,id',
            'clientes' => 'nullable|array',
            'clientes.*.id' => 'required|exists:clientes,id',
            'servicios' => 'nullable|array',
            'servicios.*.id' => 'required|exists:servicios,id',
            'servicios.*.cantidad' => 'required|numeric|min:0',
            'servicios.*.precio_aplicado' => 'required|numeric|min:0',
            'tarifas' => 'nullable|array',
            'tarifas.*.id' => 'required|exists:tarifas,id',
            'tarifas.*.dias' => 'required|numeric|min:0',
            'tarifas.*.precio_aplicado' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request) {
            $cotizacion = Cotizacion::create([
                'descripcion' => $request->descripcion,
                'fecha_ini' => $request->fecha_ini,
                'fecha_fin' => $request->fecha_fin,
                'paso' => 1,
                'user_id' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                'evento_id' => $request->evento_id,
            ]);

            if ($request->has('clientes')) {
                $syncData = [];
                foreach ($request->clientes as $cliente) {
                    $syncData[$cliente['id']] = ['estado' => true];
                }
                $cotizacion->clientes()->sync($syncData);
            }

            if ($request->has('servicios')) {
                $syncData = [];
                foreach ($request->servicios as $servicio) {
                    $syncData[$servicio['id']] = [
                        'cantidad' => $servicio['cantidad'],
                        'precio_aplicado' => $servicio['precio_aplicado'],
                        'estado' => true
                    ];
                }
                $cotizacion->servicios()->sync($syncData);
            }

            if ($request->has('tarifas')) {
                $syncData = [];
                foreach ($request->tarifas as $tarifa) {
                    $syncData[$tarifa['id']] = [
                        'dias' => $tarifa['dias'],
                        'precio_aplicado' => $tarifa['precio_aplicado'],
                        'estado' => true
                    ];
                }
                $cotizacion->tarifas()->sync($syncData);
            }

            return response()->json($cotizacion->load(['clientes', 'servicios', 'tarifas']), 201);
        });
    }

    public function show(string $id)
    {
        $cotizacion = Cotizacion::with(['user', 'evento', 'clientes', 'servicios', 'tarifas.tipoTarifa', 'tarifas.espacio'])
            ->findOrFail($id);
        return response()->json($cotizacion);
    }

    public function update(Request $request, string $id)
    {
        $cotizacion = Cotizacion::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_ini',
            'evento_id' => 'required|exists:eventos,id',
            'paso' => 'integer',
            'vencido' => 'boolean'
        ]);

        $cotizacion->update($request->only(['descripcion', 'fecha_ini', 'fecha_fin', 'paso', 'vencido', 'evento_id']));

        if ($request->has('clientes')) {
            $syncData = [];
            foreach ($request->clientes as $cliente) {
                $syncData[$cliente['id']] = ['estado' => true];
            }
            $cotizacion->clientes()->sync($syncData);
        }

        if ($request->has('servicios')) {
            $syncData = [];
            foreach ($request->servicios as $servicio) {
                $syncData[$servicio['id']] = [
                    'cantidad' => $servicio['cantidad'],
                    'precio_aplicado' => $servicio['precio_aplicado'],
                    'estado' => $servicio['estado'] ?? true
                ];
            }
            $cotizacion->servicios()->sync($syncData);
        }

        if ($request->has('tarifas')) {
            $syncData = [];
            foreach ($request->tarifas as $tarifa) {
                $syncData[$tarifa['id']] = [
                    'dias' => $tarifa['dias'],
                    'precio_aplicado' => $tarifa['precio_aplicado'],
                    'estado' => $tarifa['estado'] ?? true
                ];
            }
            $cotizacion->tarifas()->sync($syncData);
        }

        return response()->json($cotizacion->load(['clientes', 'servicios', 'tarifas']));
    }

    public function destroy(string $id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $cotizacion->delete();
        return response()->json(['message' => 'Cotización eliminada correctamente']);
    }
}
