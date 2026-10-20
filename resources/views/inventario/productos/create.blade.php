@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-plus mr-2"></i>Nuevo Producto Terminado</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('productos.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre del Producto</label>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock_actual">Stock Inicial</label>
                                    <input type="number" class="form-control @error('stock_actual') is-invalid @enderror" 
                                           id="stock_actual" name="stock_actual" value="{{ old('stock_actual', 0) }}" required min="0">
                                    @error('stock_actual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="precio_unitario">Precio Unitario ($)</label>
                                    <input type="number" step="0.01" class="form-control @error('precio_unitario') is-invalid @enderror" 
                                           id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario') }}" required min="0">
                                    @error('precio_unitario')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i>Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection