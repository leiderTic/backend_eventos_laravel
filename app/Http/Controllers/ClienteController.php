<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('tipoCliente', 'institucion')->get();
        return response()->json($clientes);
    }

    public function clienteIntituciones()
    {
        $clientes = Cliente::where('tipo_cliente_id', 1)->get();
        return response()->json($clientes);
    }

    public function clienteContactos()
    {
        $clientes = Cliente::where('tipo_cliente_id', 2)->get();
        return response()->json($clientes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci_nit' => 'nullable|string|max:20',
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255|unique:clientes,correo',
            'telefono' => 'nullable|string|max:20',
            'tipo_cliente_id' => 'required|exists:tipo_clientes,id',
            'cliente_id' => 'nullable|exists:clientes,id',
        ]);

        $cliente = Cliente::create($validated);
        return response()->json($cliente, 201);
    }

    public function show(Cliente $cliente)
    {
        return response()->json($cliente->load('tipoCliente', 'institucion'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'ci_nit' => 'nullable|string|max:20',
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255|unique:clientes,correo,' . $cliente->id,
            'telefono' => 'nullable|string|max:20',
            'tipo_cliente_id' => 'required|exists:tipo_clientes,id',
            'cliente_id' => 'nullable|exists:clientes,id',
        ]);

        $cliente->update($validated);
        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado']);
    }

    public function clienteIntitucionesContactos($id)
    {
        $clientes = Cliente::where('tipo_cliente_id', 2)->where('cliente_id', $id)->get();
        return response()->json($clientes);
    }
}
