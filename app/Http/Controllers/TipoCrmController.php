<?php

namespace App\Http\Controllers;

use App\Models\TipoCrm;
use Illuminate\Http\Request;

class TipoCrmController extends Controller
{
    /**
     * Obtener lista de tipos de CRM/Seguimiento.
     */
    public function index()
    {
        return response()->json(TipoCrm::all());
    }
}
