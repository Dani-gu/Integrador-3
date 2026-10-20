@extends('layouts.app')

@section('title', 'Nueva Materia Prima')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-plus mr-2"></i>Nueva Materia Prima</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('materia-prima.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock_actual">Stock Inicial</label>
                                    <input type="number" step="0.01" class="form-control @error('stock_actual') is-invalid @enderror" 
                                           id="stock_actual" name="stock_actual" value="{{ old('stock_actual', 0) }}" required min="0">
                                    @error('stock_actual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock_minimo">Stock Mínimo</label>
                                    <input type="number" step="0.01" class="form-control @error('stock_minimo') is-invalid @enderror" 
                                           id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo', 0) }}" required min="0">
                                    @error('stock_minimo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unidad_medida">Unidad de Medida</label>
                                    <select class="form-control @error('unidad_medida') is-invalid @enderror" id="unidad_medida" name="unidad_medida" required>
                                        <option value="">Seleccionar</option>
                                        <option value="kg" {{ old('unidad_medida') == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                                        <option value="g" {{ old('unidad_medida') == 'g' ? 'selected' : '' }}>Gramos (g)</option>
                                        <option value="l" {{ old('unidad_medida') == 'l' ? 'selected' : '' }}>Litros (l)</option>
                                        <option value="ml" {{ old('unidad_medida') == 'ml' ? 'selected' : '' }}>Mililitros (ml)</option>
                                        <option value="unidad" {{ old('unidad_medida') == 'unidad' ? 'selected' : '' }}>Unidades</option>
                                    </select>
                                    @error('unidad_medida')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('materia-prima.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection