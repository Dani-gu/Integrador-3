@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-shopping-cart mr-2"></i>Pedidos</h2>
        <a href="{{ route('pedidos.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i>Nuevo Pedido
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
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedidos as $pedido)
                        <tr>
                            <td>#{{ $pedido->id }}</td>
                            <td>{{ $pedido->cliente->nombre_razon_social }}</td>
                            <td>{{ $pedido->vendedor->nombre_completo }}</td>
                            <td>{{ $pedido->fecha_pedido->format('d/m/Y') }}</td>
                            <td>${{ number_format($pedido->total_pedido, 2) }}</td>
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
                            <td>
                                <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if(!$pedido->factura && $pedido->estado != 'cancelado')
                                <a href="{{ route('facturas.create', $pedido->id) }}" class="btn btn-sm btn-success">
                                    <i class="fa fa-file-invoice"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay pedidos registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection