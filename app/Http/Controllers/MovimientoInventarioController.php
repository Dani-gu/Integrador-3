<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimientoInventario;

class MovimientoInventarioController extends Controller
{
    public function index()
    {
        $movimientos = MovimientoInventario::with(['usuario', 'materiaPrima', 'productoTerminado'])
                                          ->latest('fecha_movimiento')
                                          ->paginate(20);
        
        return view('inventario.movimientos.index', compact('movimientos'));
    }

    public function show(MovimientoInventario $movimiento)
    {
        $movimiento->load(['usuario', 'materiaPrima', 'productoTerminado']);
        return view('inventario.movimientos.show', compact('movimiento'));
    }
}