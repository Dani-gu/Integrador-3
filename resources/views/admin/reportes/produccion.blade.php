@extends('layouts.app')

@section('title', 'Reporte de Producción')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-cogs mr-2"></i>Reporte de Producción</h2>
        <a href="{{ route('reportes.index') }}" class="btn btn-secondary">Volver a Reportes</a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.produccion') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label>Fecha Desde</label>
                        <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-3">
                        <label>Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <a href="{{ route('reportes.produccion') }}" class="btn btn-secondary btn-block">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumen -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3>{{ $resumen['total_lotes'] }}</h3>
                    <p>Total Lotes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ $resumen['lotes_finalizados'] }}</h3>
                    <p>Finalizados</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3>{{ $resumen['lotes_en_proceso'] }}</h3>
                    <p>En Proceso</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3>{{ number_format($resumen['cantidad_total']) }}</h3>
                    <p>Unidades Producidas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalle -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID Lote</th>
                            <th>Máquina</th>
                            <th>Operario</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lotes as $lote)
                        <tr>
                            <td>#{{ $lote->id }}</td>
                            <td>{{ $lote->maquina->nombre }}</td>
                            <td>{{ $lote->operario->nombre_completo }}</td>
                            <td>{{ $lote->fecha_inicio->format('d/m/Y H:i') }}</td>
                            <td>{{ $lote->fecha_fin ? $lote->fecha_fin->format('d/m/Y H:i') : 'En proceso' }}</td>
                            <td>{{ number_format($lote->cantidad_producida) }}</td>
                            <td>
                                @if($lote->estado == 'finalizado')
                                    <span class="badge badge-success">Finalizado</span>
                                @else
                                    <span class="badge badge-warning">{{ ucfirst($lote->estado) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay datos para mostrar</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection