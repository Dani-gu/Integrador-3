<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoTerminado;
use App\Models\MovimientoInventario;
use Illuminate\Support\Facades\Auth;

class ProductoTerminadoController extends Controller
{
    public function index()
    {
        $productos = ProductoTerminado::all();
        return view('inventario.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('inventario.productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
            'stock_actual' => 'required|integer|min:0',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        ProductoTerminado::create($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    public function edit(ProductoTerminado $producto)
    {
        return view('inventario.productos.edit', compact('producto'));
    }

    public function update(Request $request, ProductoTerminado $producto)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        $producto->update($request->except('stock_actual'));
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function movimiento(Request $request, ProductoTerminado $producto)
    {
        $request->validate([
            'tipo_movimiento' => 'required|in:entrada,salida_venta,ajuste',
            'cantidad' => 'required|integer|min:1'
        ]);

        $cantidad = $request->cantidad;
        if ($request->tipo_movimiento == 'salida_venta' && $producto->stock_actual < $cantidad) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente']);
        }

        // Registrar movimiento
        MovimientoInventario::create([
            'id_usuario_responsable' => Auth::id(),
            'id_producto_terminado' => $producto->id,
            'tipo_movimiento' => $request->tipo_movimiento,
            'cantidad' => $cantidad,
            'fecha_movimiento' => now()
        ]);

        // Actualizar stock
        if ($request->tipo_movimiento == 'entrada' || $request->tipo_movimiento == 'ajuste') {
            $producto->increment('stock_actual', $cantidad);
        } else {
            $producto->decrement('stock_actual', $cantidad);
        }

        return redirect()->route('productos.index')->with('success', 'Movimiento registrado exitosamente');
    }
}