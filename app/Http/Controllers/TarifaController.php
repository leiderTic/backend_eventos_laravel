<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use Illuminate\Http\Request;

class TarifaController extends Controller
{
    public function index()
    {
        $tarifas = Tarifa::with(['tipoTarifa', 'espacio'])->get();
        return response()->json($tarifas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'precio_dia' => 'required|numeric|min:0',
            'tipo_tarifa_id' => 'required|exists:tipo_tarifas,id',
            'espacio_id' => 'required|exists:espacios,id',
        ]);

        $tarifa = Tarifa::create([
            'precio_dia' => $request->precio_dia,
            'tipo_tarifa_id' => $request->tipo_tarifa_id,
            'espacio_id' => $request->espacio_id,
        ]);

        return response()->json($tarifa->load(['tipoTarifa', 'espacio']), 201);
    }

    public function show(string $id)
    {
        $tarifa = Tarifa::with(['tipoTarifa', 'espacio'])->findOrFail($id);
        return response()->json($tarifa);
    }

    public function update(Request $request, string $id)
    {
        $tarifa = Tarifa::findOrFail($id);

        $request->validate([
            'precio_dia' => 'required|numeric|min:0',
            'tipo_tarifa_id' => 'required|exists:tipo_tarifas,id',
            'espacio_id' => 'required|exists:espacios,id',
        ]);

        $tarifa->update([
            'precio_dia' => $request->precio_dia,
            'tipo_tarifa_id' => $request->tipo_tarifa_id,
            'espacio_id' => $request->espacio_id,
        ]);

        return response()->json($tarifa->load(['tipoTarifa', 'espacio']));
    }

    public function destroy(string $id)
    {
        $tarifa = Tarifa::findOrFail($id);
        $tarifa->delete();

        return response()->json(['message' => 'Tarifa eliminada correctamente']);
    }
}
