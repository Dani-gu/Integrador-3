@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reporte de Inventario</h3>
                    <div class="card-tools">
                        <a href="{{ route('reportes.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Resumen -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-boxes"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Valor Materia Prima</span>
                                    <span class="info-box-number">Bs. {{ number_format($resumen['valor_materia_prima'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-cubes"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Valor Productos</span>
                                    <span class="info-box-number">Bs. {{ number_format($resumen['valor_productos'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Stock Bajo</span>
                                    <span class="info-box-number">{{ $resumen['items_stock_bajo'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Sin Stock</span>
                                    <span class="info-box-number">{{ $resumen['productos_sin_stock'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Materia Prima -->
                    <h5>Materia Prima</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Stock Actual</th>
                                    <th>Stock Mínimo</th>
                                    <th>Unidad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materiasPrimas as $material)
                                <tr>
                                    <td>{{ $material->nombre }}</td>
                                    <td>{{ $material->stock_actual }}</td>
                                    <td>{{ $material->stock_minimo }}</td>
                                    <td>{{ $material->unidad_medida }}</td>
                                    <td>
                                        @if($material->stock_actual <= $material->stock_minimo)
                                            <span class="badge badge-danger">Stock Bajo</span>
                                        @else
                                            <span class="badge badge-success">Normal</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Productos Terminados -->
                    <h5>Productos Terminados</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Precio Unitario</th>
                                    <th>Valor Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->stock_actual }}</td>
                                    <td>Bs. {{ number_format($producto->precio_unitario, 2) }}</td>
                                    <td>Bs. {{ number_format($producto->stock_actual * $producto->precio_unitario, 2) }}</td>
                                    <td>
                                        @if($producto->stock_actual == 0)
                                            <span class="badge badge-danger">Sin Stock</span>
                                        @else
                                            <span class="badge badge-success">Disponible</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection