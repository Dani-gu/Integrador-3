@extends('layouts.app')

@section('title', 'Gestión de Máquinas')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-cogs mr-2"></i>Gestión de Máquinas</h2>
        <a href="{{ route('maquinas.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i>Nueva Máquina
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
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maquinas as $maquina)
                        <tr>
                            <td>{{ $maquina->id }}</td>
                            <td>{{ $maquina->nombre }}</td>
                            <td>
                                @if($maquina->estado == 'operativa')
                                    <span class="badge badge-success">Operativa</span>
                                @elseif($maquina->estado == 'en_mantenimiento')
                                    <span class="badge badge-warning">En Mantenimiento</span>
                                @else
                                    <span class="badge badge-danger">Fuera de Servicio</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('maquinas.edit', $maquina) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('maquinas.destroy', $maquina) }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar máquina?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay máquinas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection