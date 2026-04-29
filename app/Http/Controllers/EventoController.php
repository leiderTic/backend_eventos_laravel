<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();
        return response()->json($eventos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $evento = Evento::create([
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($evento, 201);
    }

    public function show(string $id)
    {
        $evento = Evento::findOrFail($id);
        return response()->json($evento);
    }

    public function update(Request $request, string $id)
    {
        $evento = Evento::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $evento->update([
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($evento);
    }

    public function destroy(string $id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();

        return response()->json(['message' => 'Evento eliminado correctamente']);
    }
}
