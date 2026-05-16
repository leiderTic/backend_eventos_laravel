<?php

namespace App\Http\Controllers;

use App\Models\Porcentaje;
use Illuminate\Http\Request;

class PorcentajeController extends Controller
{
    /**
     * Obtener porcentajes predefinidos.
     */
    public function index()
    {
        return response()->json(Porcentaje::all());
    }
}
