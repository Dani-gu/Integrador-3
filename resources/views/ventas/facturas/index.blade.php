@extends('layouts.app')

@section('title', 'Facturas')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-file-invoice mr-2"></i>Facturas</h2>
        <a href="{{ route('facturas.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i>Nueva Factura
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
                            <th>Nº Factura</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Estado Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facturas as $factura)
                        <tr>
                            <td><strong>#{{ str_pad($factura->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>{{ $factura->cliente->nombre_razon_social }}</td>
                            <td>{{ $factura->fecha_emision->format('d/m/Y') }}</td>
                            <td>${{ number_format($factura->monto_total, 2) }}</td>
                            <td>
                                @if($factura->estado_pago == 'pendiente')
                                    <span class="badge badge-warning">Pendiente</span>
                                @else
                                    <span class="badge badge-success">Pagada</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('facturas.show', $factura) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if($factura->estado_pago == 'pendiente')
                                <form method="POST" action="{{ route('facturas.pagar', $factura) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Marcar como pagada?')">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay facturas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection