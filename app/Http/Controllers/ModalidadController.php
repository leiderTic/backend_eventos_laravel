<?php

namespace App\Http\Controllers;

use App\Models\Modalidad;
use Illuminate\Http\Request;

class ModalidadController extends Controller
{
    /**
     * Obtener lista de modalidades de reunión.
     */
    public function index()
    {
        return response()->json(Modalidad::all());
    }
}
