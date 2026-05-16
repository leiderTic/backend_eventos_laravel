<?php

namespace App\Http\Controllers;

use App\Models\Crm;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrmController extends Controller
{
    /**
     * Listado cronológico de seguimientos CRM por cotización.
     */
    public function index($cotizacionId)
    {
        $seguimientos = Crm::with(['tipoCrm', 'user'])
            ->where('cotizacion_id', $cotizacionId)
            ->orderBy('fecha', 'desc')
            ->get();
            
        return response()->json($seguimientos);
    }

    /**
     * Registrar una nueva gestión CRM.
     */
    public function store(Request $request, $cotizacionId)
    {
        $cotizacion = Cotizacion::findOrFail($cotizacionId);
        
        $request->validate([
            'tipo_crm_id' => 'required|exists:tipo_crms,id',
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
            'resultado' => 'nullable|string'
        ]);

        $crm = Crm::create([
            'cotizacion_id' => $cotizacion->id,
            'user_id' => Auth::id() ?? 1,
            'tipo_crm_id' => $request->tipo_crm_id,
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
            'resultado' => $request->resultado
        ]);

        return response()->json($crm->load('tipoCrm'), 201);
    }
}
