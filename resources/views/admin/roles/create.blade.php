@extends('layouts.app')

@section('title', 'Nuevo Rol')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-plus mr-2"></i>Nuevo Rol</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre_rol">Nombre del Rol *</label>
                            <input type="text" class="form-control @error('nombre_rol') is-invalid @enderror" 
                                   id="nombre_rol" name="nombre_rol" value="{{ old('nombre_rol') }}" required>
                            @error('nombre_rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Ejemplo: Técnico, Jefe de Planta, etc.</small>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i>Crear Rol
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection