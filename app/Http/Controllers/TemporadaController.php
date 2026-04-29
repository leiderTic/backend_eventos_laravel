<?php

namespace App\Http\Controllers;

use App\Models\Temporada;
use Illuminate\Http\Request;

class TemporadaController extends Controller
{
    public function index()
    {
        $temporadas = Temporada::all();
        return response()->json($temporadas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'mes_inicio' => 'required|integer|min:1|max:12',
            'mes_fin' => 'required|integer|min:1|max:12',
        ]);

        $temporada = Temporada::create([
            'descripcion' => $request->descripcion,
            'mes_inicio' => $request->mes_inicio,
            'mes_fin' => $request->mes_fin,
        ]);

        return response()->json($temporada, 201);
    }

    public function show(string $id)
    {
        $temporada = Temporada::findOrFail($id);
        return response()->json($temporada);
    }

    public function update(Request $request, string $id)
    {
        $temporada = Temporada::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'mes_inicio' => 'required|integer|min:1|max:12',
            'mes_fin' => 'required|integer|min:1|max:12',
        ]);

        $temporada->update([
            'descripcion' => $request->descripcion,
            'mes_inicio' => $request->mes_inicio,
            'mes_fin' => $request->mes_fin,
        ]);

        return response()->json($temporada);
    }

    public function destroy(string $id)
    {
        $temporada = Temporada::findOrFail($id);
        $temporada->delete();

        return response()->json(['message' => 'Temporada eliminada correctamente']);
    }
}
