@extends('layouts.app')

@section('title', 'Diagnósticos de Fallas')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-exclamation-triangle mr-2"></i>Diagnósticos de Fallas</h2>
        <div>
            <a href="{{ route('soluciones.buscar') }}" class="btn btn-info mr-2">
                <i class="fa fa-search mr-1"></i>Buscar Soluciones
            </a>
            <a href="{{ route('diagnosticos.create') }}" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i>Reportar Problema
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Lote/Máquina</th>
                            <th>Problema</th>
                            <th>Reportado por</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($diagnosticos as $diagnostico)
                        <tr>
                            <td>#{{ $diagnostico->id }}</td>
                            <td>
                                @if($diagnostico->lote)
                                    Lote #{{ $diagnostico->lote->id }}<br>
                                    <small class="text-muted">{{ $diagnostico->lote->maquina->nombre }}</small>
                                @else
                                    <span class="text-muted">General</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($diagnostico->descripcion_problema, 50) }}</td>
                            <td>{{ $diagnostico->usuario->nombre_completo }}</td>
                            <td>{{ $diagnostico->fecha_reporte->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($diagnostico->estado_resolucion == 'pendiente')
                                    <span class="badge badge-warning">Pendiente</span>
                                @elseif($diagnostico->estado_resolucion == 'en_proceso')
                                    <span class="badge badge-info">En Proceso</span>
                                @else
                                    <span class="badge badge-success">Resuelto</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('diagnosticos.show', $diagnostico) }}" class="btn btn-sm btn-info mr-1">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if(Auth::user()->rol->nombre_rol === 'Administrador')
                                <a href="{{ route('diagnosticos.edit', $diagnostico) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay diagnósticos reportados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection