<?php

namespace App\Http\Controllers;

use App\Models\Reunion;
use App\Models\Cotizacion;
use App\Models\Acta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReunionController extends Controller
{
    /**
     * Listado de reuniones por cotización.
     */
    public function index($cotizacionId)
    {
        $reuniones = Reunion::with(['modalidad', 'acta', 'user'])
            ->where('cotizacion_id', $cotizacionId)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();
            
        return response()->json($reuniones);
    }

    /**
     * Registrar una nueva reunión.
     */
    public function store(Request $request, $cotizacionId)
    {
        $cotizacion = Cotizacion::findOrFail($cotizacionId);
        
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'modalidad_id' => 'required|exists:modalidades,id',
            'observaciones' => 'nullable|string',
        ]);

        $reunion = Reunion::create([
            'cotizacion_id' => $cotizacion->id,
            'user_id' => Auth::id() ?? 1,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'modalidad_id' => $request->modalidad_id,
            'observaciones' => $request->observaciones,
            'estado' => 'Programada'
        ]);

        return response()->json($reunion->load('modalidad'), 201);
    }

    /**
     * Subir acta de reunión.
     */
    public function subirActa(Request $request, $reunionId)
    {
        $reunion = Reunion::findOrFail($reunionId);
        
        $request->validate([
            'acta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'resumen_acuerdos' => 'nullable|string'
        ]);

        if ($request->hasFile('acta')) {
            $path = $request->file('acta')->store('reuniones/actas', 'public');
            
            $acta = Acta::updateOrCreate(
                ['reunion_id' => $reunion->id],
                [
                    'archivo_path' => $path,
                    'resumen_acuerdos' => $request->resumen_acuerdos
                ]
            );

            $reunion->update(['estado' => 'Realizada']);

            return response()->json($acta, 201);
        }

        return response()->json(['message' => 'No se subió ningún archivo'], 400);
    }
}
