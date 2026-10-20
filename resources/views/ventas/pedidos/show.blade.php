@extends('layouts.app')

@section('title', 'Detalle del Pedido')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-eye mr-2"></i>Pedido #{{ $pedido->id }}</h2>
        <div>
            @if($pedido->estado != 'entregado' && $pedido->estado != 'cancelado')
            <button class="btn btn-warning" data-toggle="modal" data-target="#estadoModal">
                <i class="fa fa-edit mr-1"></i>Cambiar Estado
            </button>
            @endif
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Información del Pedido</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Cliente:</strong></td>
                            <td>{{ $pedido->cliente->nombre_razon_social }}</td>
                        </tr>
                        <tr>
                            <td><strong>Vendedor:</strong></td>
                            <td>{{ $pedido->vendedor->nombre_completo }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha:</strong></td>
                            <td>{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Estado:</strong></td>
                            <td>
                                @if($pedido->estado == 'pendiente')
                                    <span class="badge badge-warning">Pendiente</span>
                                @elseif($pedido->estado == 'en_proceso')
                                    <span class="badge badge-info">En Proceso</span>
                                @elseif($pedido->estado == 'listo_para_entrega')
                                    <span class="badge badge-primary">Listo</span>
                                @elseif($pedido->estado == 'entregado')
                                    <span class="badge badge-success">Entregado</span>
                                @else
                                    <span class="badge badge-danger">Cancelado</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td><h4 class="text-primary">${{ number_format($pedido->total_pedido, 2) }}</h4></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Productos del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cant.</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedido->detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->producto->nombre }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td>${{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Estado -->
    <div class="modal fade" id="estadoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Estado del Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" action="{{ route('pedidos.estado', $pedido) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nuevo Estado</label>
                            <select name="estado" class="form-control" required>
                                <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_proceso" {{ $pedido->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="listo_para_entrega" {{ $pedido->estado == 'listo_para_entrega' ? 'selected' : '' }}>Listo para Entrega</option>
                                <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Estado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection