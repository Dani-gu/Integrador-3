@extends('layouts.app')

@section('title', 'Reportes del Sistema')

@section('content')
<div class="container-fluid py-4">
    <h2><i class="fa fa-chart-bar mr-2"></i>Reportes del Sistema</h2>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fa fa-cogs fa-3x text-primary"></i>
                    </div>
                    <h5>Reporte de Producción</h5>
                    <p class="text-muted">Lotes producidos, máquinas utilizadas y rendimiento</p>
                    <a href="{{ route('reportes.produccion') }}" class="btn btn-primary">
                        <i class="fa fa-eye mr-1"></i>Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fa fa-boxes fa-3x text-success"></i>
                    </div>
                    <h5>Reporte de Inventario</h5>
                    <p class="text-muted">Stock actual, valorización y alertas</p>
                    <a href="{{ route('reportes.inventario') }}" class="btn btn-success">
                        <i class="fa fa-eye mr-1"></i>Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fa fa-chart-line fa-3x text-info"></i>
                    </div>
                    <h5>Reporte de Ventas</h5>
                    <p class="text-muted">Pedidos, facturación y análisis de ventas</p>
                    <a href="{{ route('reportes.ventas') }}" class="btn btn-info">
                        <i class="fa fa-eye mr-1"></i>Ver Reporte
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Resumen General del Sistema</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h3 class="text-primary">{{ \App\Models\Usuario::count() }}</h3>
                            <p>Usuarios Activos</p>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-success">{{ \App\Models\LoteProduccion::where('estado', 'en_proceso')->count() }}</h3>
                            <p>Lotes en Proceso</p>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-warning">{{ \App\Models\MateriaPrima::whereRaw('stock_actual <= stock_minimo')->count() }}</h3>
                            <p>Alertas de Stock</p>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-info">${{ number_format(\App\Models\Pedido::whereMonth('fecha_pedido', now()->month)->sum('total_pedido'), 2) }}</h3>
                            <p>Ventas del Mes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection