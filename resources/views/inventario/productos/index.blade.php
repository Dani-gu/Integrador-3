@extends('layouts.app')

@section('title', 'Productos Terminados')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-cube mr-2"></i>Productos Terminados</h2>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i>Nuevo Producto
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
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Precio Unitario</th>
                            <th>Valor Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                        <tr>
                            <td>
                                <strong>{{ $producto->nombre }}</strong>
                                @if($producto->descripcion)
                                    <br><small class="text-muted">{{ $producto->descripcion }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $producto->stock_actual > 0 ? 'success' : 'danger' }}">
                                    {{ $producto->stock_actual }} unidades
                                </span>
                            </td>
                            <td>${{ number_format($producto->precio_unitario, 2) }}</td>
                            <td>${{ number_format($producto->stock_actual * $producto->precio_unitario, 2) }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#movimientoModal{{ $producto->id }}">
                                    <i class="fa fa-exchange-alt"></i>
                                </button>
                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Movimiento -->
                        <div class="modal fade" id="movimientoModal{{ $producto->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Movimiento - {{ $producto->nombre }}</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('productos.movimiento', $producto) }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Tipo de Movimiento</label>
                                                <select name="tipo_movimiento" class="form-control" required>
                                                    <option value="entrada">Entrada (Producción)</option>
                                                    <option value="salida_venta">Salida (Venta)</option>
                                                    <option value="ajuste">Ajuste de Inventario</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Cantidad (unidades)</label>
                                                <input type="number" name="cantidad" class="form-control" required min="1">
                                                <small class="text-muted">Stock actual: {{ $producto->stock_actual }} unidades</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay productos registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection