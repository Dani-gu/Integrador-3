<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\ProductoTerminado;
use App\Models\DetallePedido;
use App\Models\MovimientoInventario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'vendedor'])->latest()->get();
        return view('ventas.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = ProductoTerminado::where('stock_actual', '>', 0)->get();
        return view('ventas.pedidos.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos_terminados,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            
            // Crear pedido
            $pedido = Pedido::create([
                'id_cliente' => $request->id_cliente,
                'id_vendedor' => Auth::id(),
                'fecha_pedido' => now(),
                'estado' => 'pendiente',
                'total_pedido' => 0
            ]);

            // Procesar productos
            foreach ($request->productos as $item) {
                $producto = ProductoTerminado::find($item['id']);
                
                if ($producto->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre}");
                }

                $subtotal = $item['cantidad'] * $producto->precio_unitario;
                $total += $subtotal;

                // Crear detalle
                DetallePedido::create([
                    'id_pedido' => $pedido->id,
                    'id_producto_terminado' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_unitario
                ]);

                // Reducir stock
                $producto->decrement('stock_actual', $item['cantidad']);

                // Registrar movimiento
                MovimientoInventario::create([
                    'id_usuario_responsable' => Auth::id(),
                    'id_producto_terminado' => $producto->id,
                    'tipo_movimiento' => 'salida_venta',
                    'cantidad' => $item['cantidad'],
                    'fecha_movimiento' => now()
                ]);
            }

            $pedido->update(['total_pedido' => $total]);
        });

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'vendedor', 'detalles.producto']);
        return view('ventas.pedidos.show', compact('pedido'));
    }

    public function cambiarEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,listo_para_entrega,entregado,cancelado'
        ]);

        $pedido->update(['estado' => $request->estado]);
        return redirect()->route('pedidos.show', $pedido)->with('success', 'Estado actualizado exitosamente');
    }
}