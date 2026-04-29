<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\Request;

class EspacioController extends Controller
{
    public function index()
    {
        $espacios = Espacio::with(['tipoEspacio', 'bloque', 'tarifas.temporada', 'tarifas.tipoTarifa'])->get();
        return response()->json($espacios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'dias_max' => 'nullable|integer',
            'area_m2' => 'required|numeric|min:0',
            'aforo' => 'required|integer|min:0',
            'tipo_espacio_id' => 'required|exists:tipo_espacios,id',
            'bloque_id' => 'required|exists:bloques,id',
        ]);

        $espacio = Espacio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'dias_max' => $request->dias_max,
            'area_m2' => $request->area_m2,
            'aforo' => $request->aforo,
            'tipo_espacio_id' => $request->tipo_espacio_id,
            'bloque_id' => $request->bloque_id,
        ]);

        return response()->json($espacio->load(['tipoEspacio', 'bloque']), 201);
    }

    public function show(string $id)
    {
        $espacio = Espacio::with(['tipoEspacio', 'bloque', 'tarifas.temporada', 'tarifas.tipoTarifa'])->findOrFail($id);
        return response()->json($espacio);
    }

    public function update(Request $request, string $id)
    {
        $espacio = Espacio::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'dias_max' => 'nullable|integer',
            'area_m2' => 'required|numeric|min:0',
            'aforo' => 'required|integer|min:0',
            'tipo_espacio_id' => 'required|exists:tipo_espacios,id',
            'bloque_id' => 'required|exists:bloques,id',
        ]);

        $espacio->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'dias_max' => $request->dias_max,
            'area_m2' => $request->area_m2,
            'aforo' => $request->aforo,
            'tipo_espacio_id' => $request->tipo_espacio_id,
            'bloque_id' => $request->bloque_id,
        ]);

        return response()->json($espacio->load(['tipoEspacio', 'bloque']));
    }

    public function destroy(string $id)
    {
        $espacio = Espacio::findOrFail($id);
        $espacio->delete();

        return response()->json(['message' => 'Espacio eliminado correctamente']);
    }
}
