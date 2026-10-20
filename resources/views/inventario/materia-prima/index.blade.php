@extends('layouts.app')

@section('title', 'Materia Prima')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-boxes mr-2"></i>Materia Prima</h2>
        <a href="{{ route('materia-prima.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i>Nueva Materia Prima
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($alertasStock->count() > 0)
        <div class="alert alert-warning">
            <h5><i class="fa fa-exclamation-triangle mr-2"></i>Alertas de Stock Bajo</h5>
            @foreach($alertasStock as $alerta)
                <div>• {{ $alerta->nombre }}: {{ $alerta->stock_actual }} {{ $alerta->unidad_medida }} (Mínimo: {{ $alerta->stock_minimo }})</div>
            @endforeach
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Nombre</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>Unidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materiasPrimas as $materia)
                        <tr class="{{ $materia->tieneStockBajo() ? 'table-warning' : '' }}">
                            <td>
                                <strong>{{ $materia->nombre }}</strong>
                                @if($materia->descripcion)
                                    <br><small class="text-muted">{{ $materia->descripcion }}</small>
                                @endif
                            </td>
                            <td>{{ $materia->stock_actual }}</td>
                            <td>{{ $materia->stock_minimo }}</td>
                            <td>{{ $materia->unidad_medida }}</td>
                            <td>
                                @if($materia->tieneStockBajo())
                                    <span class="badge badge-warning">Stock Bajo</span>
                                @else
                                    <span class="badge badge-success">Normal</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#movimientoModal{{ $materia->id }}">
                                    <i class="fa fa-exchange-alt"></i>
                                </button>
                                <a href="{{ route('materia-prima.edit', $materia) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Movimiento -->
                        <div class="modal fade" id="movimientoModal{{ $materia->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Movimiento - {{ $materia->nombre }}</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('materia-prima.movimiento', $materia) }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Tipo de Movimiento</label>
                                                <select name="tipo_movimiento" class="form-control" required>
                                                    <option value="entrada">Entrada</option>
                                                    <option value="salida_produccion">Salida para Producción</option>
                                                    <option value="ajuste">Ajuste de Inventario</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Cantidad ({{ $materia->unidad_medida }})</label>
                                                <input type="number" step="0.01" name="cantidad" class="form-control" required min="0.01">
                                                <small class="text-muted">Stock actual: {{ $materia->stock_actual }} {{ $materia->unidad_medida }}</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay materia prima registrada</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection