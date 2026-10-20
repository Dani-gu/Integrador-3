@extends('layouts.app')

@section('title', 'Detalle del Lote')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-eye mr-2"></i>Lote #{{ $lote->id }}</h2>
        <div>
            @if($lote->estado == 'en_proceso')
                <a href="{{ route('parametros.create', $lote->id) }}" class="btn btn-warning">
                    <i class="fa fa-plus mr-1"></i>Registrar Parámetros
                </a>
            @endif
            <a href="{{ route('lotes.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Información del Lote</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Máquina:</strong></td>
                            <td>{{ $lote->maquina->nombre }}</td>
                        </tr>
                        <tr>
                            <td><strong>Operario:</strong></td>
                            <td>{{ $lote->operario->nombre_completo }}</td>
                        </tr>
                        <tr>
                            <td><strong>Estado:</strong></td>
                            <td>
                                @if($lote->estado == 'en_proceso')
                                    <span class="badge badge-warning">En Proceso</span>
                                @else
                                    <span class="badge badge-success">Finalizado</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Fecha Inicio:</strong></td>
                            <td>{{ $lote->fecha_inicio->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha Fin:</strong></td>
                            <td>{{ $lote->fecha_fin ? $lote->fecha_fin->format('d/m/Y H:i:s') : 'En proceso' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cantidad Producida:</strong></td>
                            <td>{{ $lote->cantidad_producida }} unidades</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Parámetros de Producción</h5>
                </div>
                <div class="card-body">
                    @if($lote->parametros->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Temp.</th>
                                        <th>Presión</th>
                                        <th>Resina</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lote->parametros->take(5) as $parametro)
                                    <tr>
                                        <td>{{ $parametro->timestamp_lectura->format('H:i') }}</td>
                                        <td>{{ $parametro->temperatura }}°C</td>
                                        <td>{{ $parametro->presion }} bar</td>
                                        <td>{{ $parametro->cantidad_resina }} kg</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($lote->parametros->count() > 5)
                            <a href="{{ route('parametros.index', $lote->id) }}" class="btn btn-sm btn-outline-primary">
                                Ver todos los parámetros ({{ $lote->parametros->count() }})
                            </a>
                        @endif
                    @else
                        <p class="text-muted">No hay parámetros registrados</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection