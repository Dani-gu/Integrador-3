@extends('layouts.app')

@section('title', 'Detalle de Factura')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-file-invoice mr-2"></i>Factura #{{ str_pad($factura->id, 6, '0', STR_PAD_LEFT) }}</h2>
        <div>
            @if($factura->estado_pago == 'pendiente')
            <form method="POST" action="{{ route('facturas.pagar', $factura) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('¿Marcar como pagada?')">
                    <i class="fa fa-check mr-1"></i>Marcar como Pagada
                </button>
            </form>
            @endif
            <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0">MATRIPLAST</h5>
                    <small>Sistema de Gestión Industrial</small>
                </div>
                <div class="col-md-6 text-right">
                    <h5 class="mb-0">FACTURA</h5>
                    <small>Nº {{ str_pad($factura->id, 6, '0', STR_PAD_LEFT) }}</small>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6>Datos del Cliente:</h6>
                    <strong>{{ $factura->razon_social_facturacion }}</strong><br>
                    NIT/CI: {{ $factura->nit_facturacion }}<br>
                    @if($factura->cliente->telefono)
                        Tel: {{ $factura->cliente->telefono }}<br>
                    @endif
                    @if($factura->cliente->email)
                        Email: {{ $factura->cliente->email }}
                    @endif
                </div>
                <div class="col-md-6 text-right">
                    <h6>Datos de la Factura:</h6>
                    <strong>Fecha:</strong> {{ $factura->fecha_emision->format('d/m/Y') }}<br>
                    <strong>Estado:</strong> 
                    @if($factura->estado_pago == 'pendiente')
                        <span class="badge badge-warning">Pendiente</span>
                    @else
                        <span class="badge badge-success">Pagada</span>
                    @endif<br>
                    @if($factura->pedido)
                        <strong>Pedido:</strong> #{{ $factura->pedido->id }}
                    @endif
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Descripción</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-right">Precio Unit.</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factura->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->descripcion_item }}</td>
                            <td class="text-center">{{ $detalle->cantidad }}</td>
                            <td class="text-right">${{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td class="text-right">${{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <th colspan="3" class="text-right">TOTAL:</th>
                            <th class="text-right">${{ number_format($factura->monto_total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <small class="text-muted">
                        Esta factura fue generada electrónicamente por el sistema MATRIPLAST.
                    </small>
                </div>
                <div class="col-md-6 text-right">
                    <button onclick="window.print()" class="btn btn-outline-primary">
                        <i class="fa fa-print mr-1"></i>Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection