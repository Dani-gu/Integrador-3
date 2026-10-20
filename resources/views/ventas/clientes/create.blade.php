@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-plus mr-2"></i>Nuevo Cliente</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clientes.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre_razon_social">Nombre/Razón Social *</label>
                            <input type="text" class="form-control @error('nombre_razon_social') is-invalid @enderror" 
                                   id="nombre_razon_social" name="nombre_razon_social" value="{{ old('nombre_razon_social') }}" required>
                            @error('nombre_razon_social')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nit_ci">NIT/CI</label>
                                    <input type="text" class="form-control @error('nit_ci') is-invalid @enderror" 
                                           id="nit_ci" name="nit_ci" value="{{ old('nit_ci') }}">
                                    @error('nit_ci')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                           id="telefono" name="telefono" value="{{ old('telefono') }}">
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i>Guardar Cliente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection