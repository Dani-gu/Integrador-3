<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParametroProduccion;
use App\Models\LoteProduccion;

class ParametroProduccionController extends Controller
{
    public function create($loteId)
    {
        $lote = LoteProduccion::with('maquina')->findOrFail($loteId);
        return view('produccion.parametros.create', compact('lote'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_lote' => 'required|exists:lotes_produccion,id',
            'temperatura' => 'required|numeric|min:0|max:500',
            'presion' => 'required|numeric|min:0|max:100',
            'cantidad_resina' => 'required|numeric|min:0'
        ]);

        ParametroProduccion::create($request->all());
        return redirect()->route('lotes.show', $request->id_lote)->with('success', 'Parámetros registrados exitosamente');
    }

    public function index($loteId)
    {
        $lote = LoteProduccion::with(['maquina', 'parametros'])->findOrFail($loteId);
        return view('produccion.parametros.index', compact('lote'));
    }
}