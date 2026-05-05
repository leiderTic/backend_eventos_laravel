<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use Illuminate\Http\Request;

class TarifaController extends Controller
{
    public function index()
    {
        $tarifas = Tarifa::with(['tipoTarifa', 'temporada', 'espacio'])->get();
        return response()->json($tarifas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'precio_dia' => 'required|numeric|min:0',
            'tipo_tarifa_id' => 'required|exists:tipo_tarifas,id',
            'temporada_id' => 'required|exists:temporadas,id',
            'espacio_id' => 'required|exists:espacios,id',
        ]);

        $tarifa = Tarifa::create([
            'precio_dia' => $request->precio_dia,
            'tipo_tarifa_id' => $request->tipo_tarifa_id,
            'temporada_id' => $request->temporada_id,
            'espacio_id' => $request->espacio_id,
        ]);

        return response()->json($tarifa->load(['tipoTarifa', 'temporada', 'espacio']), 201);
    }

    public function show(string $id)
    {
        $tarifa = Tarifa::with(['tipoTarifa', 'temporada', 'espacio'])->findOrFail($id);
        return response()->json($tarifa);
    }

    public function update(Request $request, string $id)
    {
        $tarifa = Tarifa::findOrFail($id);

        $request->validate([
            'precio_dia' => 'required|numeric|min:0',
            'tipo_tarifa_id' => 'required|exists:tipo_tarifas,id',
            'temporada_id' => 'required|exists:temporadas,id',
            'espacio_id' => 'required|exists:espacios,id',
        ]);

        $tarifa->update([
            'precio_dia' => $request->precio_dia,
            'tipo_tarifa_id' => $request->tipo_tarifa_id,
            'temporada_id' => $request->temporada_id,
            'espacio_id' => $request->espacio_id,
        ]);

        return response()->json($tarifa->load(['tipoTarifa', 'temporada', 'espacio']));
    }

    public function getByEspacio(string $espacioId)
    {
        $tarifas = Tarifa::with(['tipoTarifa', 'temporada', 'espacio'])
                         ->where('espacio_id', $espacioId)
                         ->get();
        return response()->json($tarifas);
    }

    public function getByEspacioAndTemporada(string $espacioId, string $temporadaId)
    {
        $tarifas = Tarifa::with(['tipoTarifa', 'temporada', 'espacio'])
                         ->where('espacio_id', $espacioId)
                         ->where('temporada_id', $temporadaId)
                         ->get();
        return response()->json($tarifas);
    }

    public function getByFiltro(string $espacioId, string $temporadaId, string $tipoTarifaId)
    {
        $tarifa = Tarifa::with(['tipoTarifa', 'temporada', 'espacio'])
                         ->where('espacio_id', $espacioId)
                         ->where('temporada_id', $temporadaId)
                         ->where('tipo_tarifa_id', $tipoTarifaId)
                         ->firstOrFail();
        return response()->json($tarifa);
    }

    public function getBajasByEspacio(string $espacioId)
    {
        $tarifas = Tarifa::with(['tipoTarifa', 'temporada', 'espacio'])
                         ->where('espacio_id', $espacioId)
                         ->whereHas('temporada', function ($query) {
                             $query->where('descripcion', 'like', '%baja%');
                         })
                         ->get();
        return response()->json($tarifas);
    }

    public function getAltasByEspacio(string $espacioId)
    {
        $tarifas = Tarifa::with(['tipoTarifa', 'temporada', 'espacio'])
                         ->where('espacio_id', $espacioId)
                         ->whereHas('temporada', function ($query) {
                             $query->where('descripcion', 'like', '%alta%');
                         })
                         ->get();
        return response()->json($tarifas);
    }

    public function destroy(string $id)

    {
        $tarifa = Tarifa::findOrFail($id);
        $tarifa->delete();

        return response()->json(['message' => 'Tarifa eliminada correctamente']);
    }
}
