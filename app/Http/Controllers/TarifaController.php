<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use Illuminate\Http\Request;

class TarifaController extends Controller
{
    public function index()
    {
        $tarifas = Tarifa::with(['evento', 'temporada', 'espacio'])->get();
        return response()->json($tarifas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'precio_dia' => 'required|numeric|min:0',
            'evento_id' => 'required|exists:eventos,id',
            'temporada_id' => 'required|exists:temporadas,id',
            'espacio_id' => 'required|exists:espacios,id',
        ]);

        $tarifa = Tarifa::create([
            'precio_dia' => $request->precio_dia,
            'evento_id' => $request->evento_id,
            'temporada_id' => $request->temporada_id,
            'espacio_id' => $request->espacio_id,
        ]);

        return response()->json($tarifa->load(['evento', 'temporada', 'espacio']), 201);
    }

    public function show(string $id)
    {
        $tarifa = Tarifa::with(['evento', 'temporada', 'espacio'])->findOrFail($id);
        return response()->json($tarifa);
    }

    public function update(Request $request, string $id)
    {
        $tarifa = Tarifa::findOrFail($id);

        $request->validate([
            'precio_dia' => 'required|numeric|min:0',
            'evento_id' => 'required|exists:eventos,id',
            'temporada_id' => 'required|exists:temporadas,id',
            'espacio_id' => 'required|exists:espacios,id',
        ]);

        $tarifa->update([
            'precio_dia' => $request->precio_dia,
            'evento_id' => $request->evento_id,
            'temporada_id' => $request->temporada_id,
            'espacio_id' => $request->espacio_id,
        ]);

        return response()->json($tarifa->load(['evento', 'temporada', 'espacio']));
    }

    public function getByEspacio(string $espacioId)
    {
        $tarifas = Tarifa::with(['evento', 'temporada', 'espacio'])
                         ->where('espacio_id', $espacioId)
                         ->get();
        return response()->json($tarifas);
    }

    public function getByEspacioAndTemporada(string $espacioId, string $temporadaId)
    {
        $tarifas = Tarifa::with(['evento', 'temporada', 'espacio'])
                         ->where('espacio_id', $espacioId)
                         ->where('temporada_id', $temporadaId)
                         ->get();
        return response()->json($tarifas);
    }

    public function getByFiltro(string $espacioId, string $temporadaId, string $eventoId)
    {
        $tarifa = Tarifa::with(['evento', 'temporada', 'espacio'])
                         ->where('espacio_id', $espacioId)
                         ->where('temporada_id', $temporadaId)
                         ->where('evento_id', $eventoId)
                         ->firstOrFail();
        return response()->json($tarifa);
    }

    public function getBajasByEspacio(string $espacioId)
    {
        $tarifas = Tarifa::with(['evento', 'temporada', 'espacio'])
                         ->where('espacio_id', $espacioId)
                         ->whereHas('temporada', function ($query) {
                             $query->where('descripcion', 'like', '%baja%');
                         })
                         ->get();
        return response()->json($tarifas);
    }

    public function getAltasByEspacio(string $espacioId)
    {
        $tarifas = Tarifa::with(['evento', 'temporada', 'espacio'])
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
