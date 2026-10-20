@extends('layouts.app')

@section('title', 'Registrar Parámetros')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="fa fa-chart-bar mr-2"></i>Registrar Parámetros de Producción</h4>
                    <small>Lote #{{ $lote->id }} - {{ $lote->maquina->nombre }}</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('parametros.store') }}">
                        @csrf
                        <input type="hidden" name="id_lote" value="{{ $lote->id }}">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="temperatura">Temperatura (°C)</label>
                                    <input type="number" step="0.01" class="form-control @error('temperatura') is-invalid @enderror" 
                                           id="temperatura" name="temperatura" value="{{ old('temperatura') }}" 
                                           min="0" max="500" required>
                                    @error('temperatura')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Rango: 0-500°C</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="presion">Presión (bar)</label>
                                    <input type="number" step="0.01" class="form-control @error('presion') is-invalid @enderror" 
                                           id="presion" name="presion" value="{{ old('presion') }}" 
                                           min="0" max="100" required>
                                    @error('presion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Rango: 0-100 bar</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_resina">Cantidad de Resina (kg)</label>
                                    <input type="number" step="0.01" class="form-control @error('cantidad_resina') is-invalid @enderror" 
                                           id="cantidad_resina" name="cantidad_resina" value="{{ old('cantidad_resina') }}" 
                                           min="0" required>
                                    @error('cantidad_resina')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">En kilogramos</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            <strong>Información:</strong> Los parámetros se registrarán con la fecha y hora actual.
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('lotes.show', $lote) }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save mr-1"></i>Registrar Parámetros
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection