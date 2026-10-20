<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrediccionVentaController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistema MATRIPLAST
|--------------------------------------------------------------------------
*/

// Ruta principal - redirige al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas de Producción
    Route::resource('maquinas', App\Http\Controllers\MaquinaController::class);
    Route::resource('lotes', App\Http\Controllers\LoteProduccionController::class);
    Route::post('lotes/{lote}/finalizar', [App\Http\Controllers\LoteProduccionController::class, 'finalizar'])->name('lotes.finalizar');
    
    // Rutas de Parámetros
    Route::get('lotes/{lote}/parametros/create', [App\Http\Controllers\ParametroProduccionController::class, 'create'])->name('parametros.create');
    Route::post('parametros', [App\Http\Controllers\ParametroProduccionController::class, 'store'])->name('parametros.store');
    Route::get('lotes/{lote}/parametros', [App\Http\Controllers\ParametroProduccionController::class, 'index'])->name('parametros.index');
    
    // Rutas de Diagnósticos
    Route::resource('diagnosticos', App\Http\Controllers\DiagnosticoController::class);
    Route::post('diagnosticos/{diagnostico}/estado', [App\Http\Controllers\DiagnosticoController::class, 'cambiarEstado'])->name('diagnosticos.estado');
    Route::get('soluciones/buscar', [App\Http\Controllers\DiagnosticoController::class, 'buscarSolucion'])->name('soluciones.buscar');
    
    // Rutas de Inventario
    Route::resource('materia-prima', App\Http\Controllers\MateriaPrimaController::class);
    Route::post('materia-prima/{materiaPrima}/movimiento', [App\Http\Controllers\MateriaPrimaController::class, 'movimiento'])->name('materia-prima.movimiento');
    
    Route::resource('productos', App\Http\Controllers\ProductoTerminadoController::class);
    Route::post('productos/{producto}/movimiento', [App\Http\Controllers\ProductoTerminadoController::class, 'movimiento'])->name('productos.movimiento');
    
    Route::resource('movimientos', App\Http\Controllers\MovimientoInventarioController::class)->only(['index', 'show']);
    
    // Rutas de Ventas
    Route::resource('clientes', App\Http\Controllers\ClienteController::class);
    Route::resource('pedidos', App\Http\Controllers\PedidoController::class);
    Route::post('pedidos/{pedido}/estado', [App\Http\Controllers\PedidoController::class, 'cambiarEstado'])->name('pedidos.estado');
    
    Route::resource('facturas', App\Http\Controllers\FacturaController::class);
    Route::get('facturas/create/{pedido?}', [App\Http\Controllers\FacturaController::class, 'create'])->name('facturas.create');
    Route::post('facturas/{factura}/pagar', [App\Http\Controllers\FacturaController::class, 'marcarPagada'])->name('facturas.pagar');
     // =====================================================
    // PREDICCIÓN DE VENTAS CON MACHINE LEARNING
    // =====================================================

    Route::post(
        '/prediccion-venta',
        [PrediccionVentaController::class, 'predecir']
    )->name('prediccion.venta');
    Route::get(
    '/prediccion-venta',
    [PrediccionVentaController::class, 'formulario']
)->name('prediccion.formulario');
    
    // Rutas de Administración (solo Administrador)
    Route::middleware('can:administrar')->group(function () {
        Route::resource('usuarios', App\Http\Controllers\UsuarioController::class);
        Route::resource('roles', App\Http\Controllers\RolController::class);
        Route::resource('logs', App\Http\Controllers\LogAccionController::class)->only(['index', 'show']);
        
        // Reportes
        Route::get('reportes', [App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');
        Route::get('reportes/produccion', [App\Http\Controllers\ReporteController::class, 'produccion'])->name('reportes.produccion');
        Route::get('reportes/inventario', [App\Http\Controllers\ReporteController::class, 'inventario'])->name('reportes.inventario');
        Route::get('reportes/ventas', [App\Http\Controllers\ReporteController::class, 'ventas'])->name('reportes.ventas');
        
    });
});
