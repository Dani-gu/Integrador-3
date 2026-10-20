@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reporte de Ventas</h3>
                    <div class="card-tools">
                        <a href="{{ route('reportes.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Fecha Desde:</label>
                                <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                            </div>
                            <div class="col-md-4">
                                <label>Fecha Hasta:</label>
                                <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Resumen -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Pedidos</span>
                                    <span class="info-box-number">{{ $resumen['total_pedidos'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Ventas Totales</span>
                                    <span class="info-box-number">Bs. {{ number_format($resumen['ventas_totales'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Facturas Pendientes</span>
                                    <span class="info-box-number">{{ $resumen['facturas_pendientes'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Facturas Pagadas</span>
                                    <span class="info-box-number">{{ $resumen['facturas_pagadas'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Pedidos -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pedidos as $pedido)
                                <tr>
                                    <td>#{{ $pedido->id }}</td>
                                    <td>{{ $pedido->cliente->nombre_razon_social }}</td>
                                    <td>{{ $pedido->vendedor->nombre_completo }}</td>
                                    <td>{{ $pedido->fecha_pedido->format('d/m/Y') }}</td>
                                    <td>Bs. {{ number_format($pedido->total_pedido, 2) }}</td>
                                    <td>
                                        @if($pedido->estado == 'pendiente')
                                            <span class="badge badge-warning">Pendiente</span>
                                        @elseif($pedido->estado == 'procesando')
                                            <span class="badge badge-info">Procesando</span>
                                        @elseif($pedido->estado == 'completado')
                                            <span class="badge badge-success">Completado</span>
                                        @else
                                            <span class="badge badge-danger">Cancelado</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay pedidos en el período seleccionado</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection