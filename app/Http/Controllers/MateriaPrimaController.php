<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MateriaPrima;
use App\Models\MovimientoInventario;
use Illuminate\Support\Facades\Auth;

class MateriaPrimaController extends Controller
{
    public function index()
    {
        $materiasPrimas = MateriaPrima::all();
        $alertasStock = MateriaPrima::whereRaw('stock_actual <= stock_minimo')->get();
        
        return view('inventario.materia-prima.index', compact('materiasPrimas', 'alertasStock'));
    }

    public function create()
    {
        return view('inventario.materia-prima.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
            'stock_actual' => 'required|numeric|min:0',
            'stock_minimo' => 'required|numeric|min:0',
            'unidad_medida' => 'required|max:20'
        ]);

        MateriaPrima::create($request->all());
        return redirect()->route('materia-prima.index')->with('success', 'Materia prima creada exitosamente');
    }

    public function edit(MateriaPrima $materiaPrima)
    {
        return view('inventario.materia-prima.edit', compact('materiaPrima'));
    }

    public function update(Request $request, MateriaPrima $materiaPrima)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
            'stock_minimo' => 'required|numeric|min:0',
            'unidad_medida' => 'required|max:20'
        ]);

        $materiaPrima->update($request->except('stock_actual'));
        return redirect()->route('materia-prima.index')->with('success', 'Materia prima actualizada exitosamente');
    }

    public function movimiento(Request $request, MateriaPrima $materiaPrima)
    {
        $request->validate([
            'tipo_movimiento' => 'required|in:entrada,salida_produccion,ajuste',
            'cantidad' => 'required|numeric|min:0.01'
        ]);

        $cantidad = $request->cantidad;
        if ($request->tipo_movimiento == 'salida_produccion' && $materiaPrima->stock_actual < $cantidad) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente']);
        }

        // Registrar movimiento
        MovimientoInventario::create([
            'id_usuario_responsable' => Auth::id(),
            'id_materia_prima' => $materiaPrima->id,
            'tipo_movimiento' => $request->tipo_movimiento,
            'cantidad' => $cantidad,
            'fecha_movimiento' => now()
        ]);

        // Actualizar stock
        if ($request->tipo_movimiento == 'entrada' || $request->tipo_movimiento == 'ajuste') {
            $materiaPrima->increment('stock_actual', $cantidad);
        } else {
            $materiaPrima->decrement('stock_actual', $cantidad);
        }

        return redirect()->route('materia-prima.index')->with('success', 'Movimiento registrado exitosamente');
    }
}