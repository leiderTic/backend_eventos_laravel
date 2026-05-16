<?php

namespace App\Http\Controllers;

use App\Models\TipoRespaldo;
use Illuminate\Http\Request;

class TipoRespaldoController extends Controller
{
    /**
     * Obtener tipos de respaldos.
     */
    public function index()
    {
        return response()->json(TipoRespaldo::all());
    }
}
