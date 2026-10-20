@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="fa fa-edit mr-2"></i>Editar Usuario</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label for="nombre_completo">Nombre Completo *</label>
                            <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror" 
                                   id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo', $usuario->nombre_completo) }}" required>
                            @error('nombre_completo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_rol">Rol *</label>
                            <select class="form-control @error('id_rol') is-invalid @enderror" id="id_rol" name="id_rol" required>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ old('id_rol', $usuario->id_rol) == $rol->id ? 'selected' : '' }}>
                                        {{ $rol->nombre_rol }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Nueva Contraseña (opcional)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save mr-1"></i>Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection