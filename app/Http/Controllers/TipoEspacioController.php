<?php

namespace App\Http\Controllers;

use App\Models\TipoEspacio;
use Illuminate\Http\Request;

class TipoEspacioController extends Controller
{
    public function index()
    {
        $tipos = TipoEspacio::all();
        return response()->json($tipos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo = TipoEspacio::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json($tipo, 201);
    }

    public function show(string $id)
    {
        $tipo = TipoEspacio::findOrFail($id);
        return response()->json($tipo);
    }

    public function update(Request $request, string $id)
    {
        $tipo = TipoEspacio::findOrFail($id);

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
        $tipo = TipoEspacio::findOrFail($id);
        $tipo->delete();

        return response()->json(['message' => 'Tipo de espacio eliminado correctamente']);
    }
}
