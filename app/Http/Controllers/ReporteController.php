<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\LoteProduccion;
use App\Models\MateriaPrima;
use App\Models\ProductoTerminado;
use App\Models\Pedido;
use App\Models\Factura;
use App\Models\MovimientoInventario;

class ReporteController extends Controller
{
    public function index()
    {
        return view('admin.reportes.index');
    }

    public function produccion(Request $request)
    {
        $query = LoteProduccion::with(['maquina', 'operario']);

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_inicio', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_inicio', '<=', $request->fecha_hasta);
        }

        $lotes = $query->latest('fecha_inicio')->get();
        
        $resumen = [
            'total_lotes' => $lotes->count(),
            'lotes_finalizados' => $lotes->where('estado', 'finalizado')->count(),
            'lotes_en_proceso' => $lotes->where('estado', 'en_proceso')->count(),
            'cantidad_total' => $lotes->sum('cantidad_producida')
        ];

        return view('admin.reportes.produccion', compact('lotes', 'resumen'));
    }

    public function inventario()
    {
        $materiasPrimas = MateriaPrima::all();
        $productos = ProductoTerminado::all();
        
        $resumen = [
            'valor_materia_prima' => $materiasPrimas->sum(function($m) { return $m->stock_actual * 10; }), // Precio estimado
            'valor_productos' => $productos->sum(function($p) { return $p->stock_actual * $p->precio_unitario; }),
            'items_stock_bajo' => $materiasPrimas->filter(function($m) { return $m->tieneStockBajo(); })->count(),
            'productos_sin_stock' => $productos->where('stock_actual', 0)->count()
        ];

        return view('admin.reportes.inventario', compact('materiasPrimas', 'productos', 'resumen'));
    }

    public function ventas(Request $request)
    {
        $query = Pedido::with(['cliente', 'vendedor']);

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_pedido', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_pedido', '<=', $request->fecha_hasta);
        }

        $pedidos = $query->latest('fecha_pedido')->get();
        $facturas = Factura::whereIn('id_pedido', $pedidos->pluck('id'))->get();
        
        $resumen = [
            'total_pedidos' => $pedidos->count(),
            'ventas_totales' => $pedidos->sum('total_pedido'),
            'facturas_pendientes' => $facturas->where('estado_pago', 'pendiente')->count(),
            'facturas_pagadas' => $facturas->where('estado_pago', 'pagada')->count()
        ];

        return view('admin.reportes.ventas', compact('pedidos', 'resumen'));
    }
}