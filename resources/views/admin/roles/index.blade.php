@extends('layouts.app')

@section('title', 'Gestión de Roles')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-shield-alt mr-2"></i>Gestión de Roles</h2>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i>Nuevo Rol
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Rol</th>
                            <th>Usuarios Asignados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $rol)
                        <tr>
                            <td>{{ $rol->id }}</td>
                            <td><strong>{{ $rol->nombre_rol }}</strong></td>
                            <td>
                                <span class="badge badge-info">{{ $rol->usuarios_count }} usuarios</span>
                            </td>
                            <td>
                                <a href="{{ route('roles.edit', $rol) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @if($rol->usuarios_count == 0)
                                <form method="POST" action="{{ route('roles.destroy', $rol) }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar rol?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay roles registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection