@extends('layouts.app')

@section('title', 'Logs del Sistema')

@section('content')
<div class="container-fluid py-4">
    <h2><i class="fa fa-history mr-2"></i>Logs del Sistema</h2>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('logs.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="usuario" class="form-control" placeholder="Buscar por usuario" value="{{ request('usuario') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="tabla" class="form-control">
                            <option value="">Todas las tablas</option>
                            @foreach($tablas as $tabla)
                                <option value="{{ $tabla }}" {{ request('tabla') == $tabla ? 'selected' : '' }}>
                                    {{ ucfirst($tabla) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mr-2">Filtrar</button>
                        <a href="{{ route('logs.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Tabla</th>
                            <th>ID Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->fecha_accion->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $log->usuario ? $log->usuario->nombre_completo : 'Sistema' }}</td>
                            <td>{{ $log->accion_realizada }}</td>
                            <td>
                                @if($log->tabla_afectada)
                                    <span class="badge badge-secondary">{{ $log->tabla_afectada }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $log->id_registro_afectado ?: '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay logs registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection