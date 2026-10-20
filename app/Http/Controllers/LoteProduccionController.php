<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoteProduccion;
use App\Models\Maquina;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class LoteProduccionController extends Controller
{
    public function index()
    {
        $lotes = LoteProduccion::with(['maquina', 'operario'])->latest()->get();
        return view('produccion.lotes.index', compact('lotes'));
    }

    public function create()
    {
        $maquinas = Maquina::where('estado', 'operativa')->get();
        $operarios = Usuario::whereHas('rol', function($q) {
            $q->where('nombre_rol', 'Operario');
        })->get();
        
        return view('produccion.lotes.create', compact('maquinas', 'operarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_maquina' => 'required|exists:maquinas,id',
            'id_operario' => 'required|exists:usuarios,id',
            'cantidad_producida' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        $data['fecha_inicio'] = now();
        $data['estado'] = 'en_proceso';

        LoteProduccion::create($data);
        return redirect()->route('lotes.index')->with('success', 'Lote iniciado exitosamente');
    }

    public function show(LoteProduccion $lote)
    {
        $lote->load(['maquina', 'operario', 'parametros']);
        return view('produccion.lotes.show', compact('lote'));
    }

    public function finalizar(LoteProduccion $lote)
    {
        $lote->update([
            'fecha_fin' => now(),
            'estado' => 'finalizado'
        ]);

        return redirect()->route('lotes.index')->with('success', 'Lote finalizado exitosamente');
    }
}