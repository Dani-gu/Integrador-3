<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class PrediccionVentaController extends Controller
{
    // Mostrar formulario de predicción
    public function formulario()
    {
        $productos = DB::table('productos_terminados')
            ->select('id', 'nombre', 'precio_unitario')
            ->get();

        $clientes = DB::table('clientes')
            ->select('id', 'nombre_razon_social')
            ->get();

        $vendedores = DB::table('usuarios')
            ->select('id', 'nombre_completo')
            ->get();

        return view('prediccion-venta', compact(
            'productos',
            'clientes',
            'vendedores'
        ));
    }


    // Enviar datos al modelo de Machine Learning
    public function predecir(Request $request)
    {
        $request->validate([
            'producto' => 'required',
            'mes' => 'required|integer|min:1|max:12',
            'cliente' => 'required',
            'vendedor' => 'required',
        ]);

        // Buscar producto en la base de datos
        $producto = DB::table('productos_terminados')
            ->where('id', $request->producto)
            ->first();

        // Buscar cliente en la base de datos
        $cliente = DB::table('clientes')
            ->where('id', $request->cliente)
            ->first();

        // Buscar vendedor en la base de datos
        $vendedor = DB::table('usuarios')
            ->where('id', $request->vendedor)
            ->first();

        if (!$producto || !$cliente || !$vendedor) {
            return back()->with('error', 'No se encontraron los datos seleccionados.');
        }

        // Datos que se enviarán a FastAPI
        $datos = [
            'producto' => $producto->nombre,
            'mes' => (int) $request->mes,
            'precio_unitario' => (float) $producto->precio_unitario,
            'cliente' => $cliente->nombre_razon_social,
            'vendedor' => $vendedor->nombre_completo,
        ];

        // Conectar con la API de Machine Learning
        $respuesta = Http::post(
            'http://127.0.0.1:8000/predecir',
            $datos
        );

        if ($respuesta->failed()) {
            return back()->with(
                'error',
                'No se pudo conectar con el modelo de Machine Learning.'
            );
        }

        $resultado = $respuesta->json();

        return view('prediccion-venta', [
            'productos' => DB::table('productos_terminados')
                ->select('id', 'nombre', 'precio_unitario')
                ->get(),

            'clientes' => DB::table('clientes')
                ->select('id', 'nombre_razon_social')
                ->get(),

            'vendedores' => DB::table('usuarios')
                ->select('id', 'nombre_completo')
                ->get(),

            'resultado' => $resultado
        ]);
    }
}