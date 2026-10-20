@extends('layouts.app')

@section('title', 'Movimientos de Inventario')

@section('content')
<div class="container-fluid py-4">
    <h2><i class="fa fa-exchange-alt mr-2"></i>Movimientos de Inventario</h2>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Tipo</th>
                            <th>Item</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movimientos as $movimiento)
                        <tr>
                            <td>{{ $movimiento->fecha_movimiento->format('d/m/Y H:i') }}</td>
                            <td>{{ $movimiento->usuario->nombre_completo }}</td>
                            <td>
                                @if($movimiento->tipo_movimiento == 'entrada')
                                    <span class="badge badge-success">Entrada</span>
                                @elseif($movimiento->tipo_movimiento == 'salida_produccion')
                                    <span class="badge badge-warning">Salida Producción</span>
                                @elseif($movimiento->tipo_movimiento == 'salida_venta')
                                    <span class="badge badge-info">Salida Venta</span>
                                @else
                                    <span class="badge badge-secondary">Ajuste</span>
                                @endif
                            </td>
                            <td>
                                @if($movimiento->materiaPrima)
                                    <i class="fa fa-boxes mr-1"></i>{{ $movimiento->materiaPrima->nombre }}
                                @elseif($movimiento->productoTerminado)
                                    <i class="fa fa-cube mr-1"></i>{{ $movimiento->productoTerminado->nombre }}
                                @endif
                            </td>
                            <td>
                                {{ $movimiento->cantidad }}
                                @if($movimiento->materiaPrima)
                                    {{ $movimiento->materiaPrima->unidad_medida }}
                                @else
                                    unidades
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('movimientos.show', $movimiento) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay movimientos registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $movimientos->links() }}
        </div>
    </div>
</div>
@endsection