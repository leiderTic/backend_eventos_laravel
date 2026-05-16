<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    /**
     * Obtener lista de bancos.
     */
    public function index()
    {
        return response()->json(Banco::all());
    }
}
