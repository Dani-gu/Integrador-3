<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Pedido;
use App\Models\DetalleFactura;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with('cliente')->latest()->get();
        return view('ventas.facturas.index', compact('facturas'));
    }

    public function create($pedidoId = null)
    {
        $pedido = null;
        if ($pedidoId) {
            $pedido = Pedido::with(['cliente', 'detalles.producto'])->findOrFail($pedidoId);
        }
        
        return view('ventas.facturas.create', compact('pedido'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pedido' => 'nullable|exists:pedidos,id',
            'id_cliente' => 'required|exists:clientes,id',
            'nit_facturacion' => 'required|max:20',
            'razon_social_facturacion' => 'required|max:255',
            'items' => 'required|array|min:1',
            'items.*.descripcion' => 'required|max:255',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0'
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;

            // Crear factura
            $factura = Factura::create([
                'id_pedido' => $request->id_pedido,
                'id_cliente' => $request->id_cliente,
                'fecha_emision' => now(),
                'monto_total' => 0,
                'estado_pago' => 'pendiente',
                'nit_facturacion' => $request->nit_facturacion,
                'razon_social_facturacion' => $request->razon_social_facturacion
            ]);

            // Crear detalles
            foreach ($request->items as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                $total += $subtotal;

                DetalleFactura::create([
                    'id_factura' => $factura->id,
                    'descripcion_item' => $item['descripcion'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $subtotal
                ]);
            }

            $factura->update(['monto_total' => $total]);
        });

        return redirect()->route('facturas.index')->with('success', 'Factura creada exitosamente');
    }

    public function show(Factura $factura)
    {
        $factura->load(['cliente', 'pedido', 'detalles']);
        return view('ventas.facturas.show', compact('factura'));
    }

    public function marcarPagada(Factura $factura)
    {
        $factura->update(['estado_pago' => 'pagada']);
        return redirect()->route('facturas.show', $factura)->with('success', 'Factura marcada como pagada');
    }
}