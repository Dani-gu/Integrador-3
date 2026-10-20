@extends('layouts.app')

@section('title', 'Lotes de Producción')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-tasks mr-2"></i>Lotes de Producción</h2>
        <a href="{{ route('lotes.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i>Nuevo Lote
        </a>
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
                            <th>Máquina</th>
                            <th>Operario</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lotes as $lote)
                        <tr>
                            <td>{{ $lote->id }}</td>
                            <td>{{ $lote->maquina->nombre }}</td>
                            <td>{{ $lote->operario->nombre_completo }}</td>
                            <td>{{ $lote->fecha_inicio ? $lote->fecha_inicio->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $lote->fecha_fin ? $lote->fecha_fin->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $lote->cantidad_producida }}</td>
                            <td>
                                @if($lote->estado == 'en_proceso')
                                    <span class="badge badge-warning">En Proceso</span>
                                @elseif($lote->estado == 'finalizado')
                                    <span class="badge badge-success">Finalizado</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($lote->estado) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('lotes.show', $lote) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if($lote->estado == 'en_proceso')
                                <form method="POST" action="{{ route('lotes.finalizar', $lote) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Finalizar lote?')">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay lotes registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection