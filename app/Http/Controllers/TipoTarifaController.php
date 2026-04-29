<?php

namespace App\Http\Controllers;

use App\Models\TipoTarifa;
use Illuminate\Http\Request;

class TipoTarifaController extends Controller
{
    public function index()
    {
        $tipos = TipoTarifa::all();
        return response()->json($tipos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo = TipoTarifa::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json($tipo, 201);
    }

    public function show(string $id)
    {
        $tipo = TipoTarifa::findOrFail($id);
        return response()->json($tipo);
    }

    public function update(Request $request, string $id)
    {
        $tipo = TipoTarifa::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json($tipo);
    }

    public function destroy(string $id)
    {
        $tipo = TipoTarifa::findOrFail($id);
        $tipo->delete();

        return response()->json(['message' => 'Tipo de tarifa eliminada correctamente']);
    }
}
