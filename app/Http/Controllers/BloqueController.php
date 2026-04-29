<?php

namespace App\Http\Controllers;

use App\Models\Bloque;
use Illuminate\Http\Request;

class BloqueController extends Controller
{
    public function index()
    {
        $bloques = Bloque::all();
        return response()->json($bloques);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
        ]);

        $bloque = Bloque::create([
            'descripcion' => $request->descripcion,
            'color' => $request->color,
        ]);

        return response()->json($bloque, 201);
    }

    public function show(string $id)
    {
        $bloque = Bloque::findOrFail($id);
        return response()->json($bloque);
    }

    public function update(Request $request, string $id)
    {
        $bloque = Bloque::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
        ]);

        $bloque->update([
            'descripcion' => $request->descripcion,
            'color' => $request->color,
        ]);

        return response()->json($bloque);
    }

    public function destroy(string $id)
    {
        $bloque = Bloque::findOrFail($id);
        $bloque->delete();

        return response()->json(['message' => 'Bloque eliminado correctamente']);
    }
}
