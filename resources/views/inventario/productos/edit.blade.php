@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="fa fa-edit mr-2"></i>Editar Producto Terminado</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('productos.update', $producto) }}">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label for="nombre">Nombre del Producto</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Stock Actual</label>
                                    <input type="text" class="form-control" value="{{ $producto->stock_actual }} unidades" readonly>
                                    <small class="text-muted">Use movimientos para cambiar stock</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="precio_unitario">Precio Unitario ($)</label>
                                    <input type="number" step="0.01" class="form-control @error('precio_unitario') is-invalid @enderror" 
                                           id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario', $producto->precio_unitario) }}" required min="0">
                                    @error('precio_unitario')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save mr-1"></i>Actualizar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection