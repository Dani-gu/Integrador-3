<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::withCount('pedidos')->get();
        return view('ventas.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('ventas.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_razon_social' => 'required|max:255',
            'nit_ci' => 'nullable|unique:clientes,nit_ci|max:20',
            'telefono' => 'nullable|max:30',
            'email' => 'nullable|email|max:100'
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load(['pedidos.detalles.producto', 'facturas']);
        return view('ventas.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('ventas.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre_razon_social' => 'required|max:255',
            'nit_ci' => 'nullable|unique:clientes,nit_ci,' . $cliente->id . '|max:20',
            'telefono' => 'nullable|max:30',
            'email' => 'nullable|email|max:100'
        ]);

        $cliente->update($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente');
    }
}