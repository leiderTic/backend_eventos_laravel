<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all();
        return response()->json($servicios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'nullable|string|max:10',
            'nombre' => 'required|string|max:255',
            'unidad' => 'nullable|string|max:50',
            'precio' => 'required|numeric|min:0',
            'porEv' => 'boolean',
            'nota' => 'nullable|string',
        ]);

        $servicio = Servicio::create($request->all());

        return response()->json($servicio, 201);
    }

    public function show(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        return response()->json($servicio);
    }

    public function update(Request $request, string $id)
    {
        $servicio = Servicio::findOrFail($id);

        $request->validate([
            'codigo' => 'nullable|string|max:10',
            'nombre' => 'required|string|max:255',
            'unidad' => 'nullable|string|max:50',
            'precio' => 'required|numeric|min:0',
            'porEv' => 'boolean',
            'nota' => 'nullable|string',
        ]);

        $servicio->update($request->all());

        return response()->json($servicio);
    }

    public function destroy(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente']);
    }
}
