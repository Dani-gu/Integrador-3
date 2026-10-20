<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maquina;
use App\Models\LogAccion;

class MaquinaController extends Controller
{
    public function index()
    {
        $maquinas = Maquina::all();
        return view('produccion.maquinas.index', compact('maquinas'));
    }

    public function create()
    {
        return view('produccion.maquinas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'estado' => 'required|in:operativa,en_mantenimiento,fuera_de_servicio'
        ]);

        $maquina = Maquina::create($request->all());
        LogAccion::registrar("Máquina creada: {$maquina->nombre}", 'maquinas', $maquina->id);
        return redirect()->route('maquinas.index')->with('success', 'Máquina creada exitosamente');
    }

    public function edit(Maquina $maquina)
    {
        return view('produccion.maquinas.edit', compact('maquina'));
    }

    public function update(Request $request, Maquina $maquina)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'estado' => 'required|in:operativa,en_mantenimiento,fuera_de_servicio'
        ]);

        $maquina->update($request->all());
        LogAccion::registrar("Máquina actualizada: {$maquina->nombre}", 'maquinas', $maquina->id);
        return redirect()->route('maquinas.index')->with('success', 'Máquina actualizada exitosamente');
    }

    public function destroy(Maquina $maquina)
    {
        LogAccion::registrar("Máquina eliminada: {$maquina->nombre}", 'maquinas', $maquina->id);
        $maquina->delete();
        return redirect()->route('maquinas.index')->with('success', 'Máquina eliminada exitosamente');
    }
}