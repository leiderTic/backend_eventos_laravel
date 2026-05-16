<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Respaldo;
use Illuminate\Http\Request;

class RespaldoController extends Controller
{
    /**
     * Subir un archivo de respaldo para la cotización.
     */
    public function store(Request $request, $cotizacionId)
    {
        $cotizacion = Cotizacion::findOrFail($cotizacionId);

        $request->validate([
            'archivo' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'id_tipo_respaldo' => 'required|exists:tipo_respaldos,id',
        ]);

        $path = $request->file('archivo')->store('respaldos', 'public');

        $respaldo = Respaldo::create([
            'archivo_path' => $path,
            'id_tipo_respaldo' => $request->id_tipo_respaldo,
            'cotizacion_id' => $cotizacion->id,
        ]);

        return response()->json([
            'message' => 'Archivo de respaldo subido correctamente.',
            'respaldo' => $respaldo
        ], 201);
    }
}
