@extends('layouts.app')

@section('title', 'Editar Materia Prima')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="fa fa-edit mr-2"></i>Editar Materia Prima</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('materia-prima.update', $materiaPrima) }}">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $materiaPrima->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $materiaPrima->descripcion) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Stock Actual</label>
                                    <input type="text" class="form-control" value="{{ $materiaPrima->stock_actual }}" readonly>
                                    <small class="text-muted">Use movimientos para cambiar stock</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock_minimo">Stock Mínimo</label>
                                    <input type="number" step="0.01" class="form-control @error('stock_minimo') is-invalid @enderror" 
                                           id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo', $materiaPrima->stock_minimo) }}" required min="0">
                                    @error('stock_minimo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unidad_medida">Unidad de Medida</label>
                                    <select class="form-control @error('unidad_medida') is-invalid @enderror" id="unidad_medida" name="unidad_medida" required>
                                        <option value="kg" {{ old('unidad_medida', $materiaPrima->unidad_medida) == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                                        <option value="g" {{ old('unidad_medida', $materiaPrima->unidad_medida) == 'g' ? 'selected' : '' }}>Gramos (g)</option>
                                        <option value="l" {{ old('unidad_medida', $materiaPrima->unidad_medida) == 'l' ? 'selected' : '' }}>Litros (l)</option>
                                        <option value="ml" {{ old('unidad_medida', $materiaPrima->unidad_medida) == 'ml' ? 'selected' : '' }}>Mililitros (ml)</option>
                                        <option value="unidad" {{ old('unidad_medida', $materiaPrima->unidad_medida) == 'unidad' ? 'selected' : '' }}>Unidades</option>
                                    </select>
                                    @error('unidad_medida')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('materia-prima.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save mr-1"></i>Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection