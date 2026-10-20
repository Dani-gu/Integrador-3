@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Estado - Diagnóstico #{{ $diagnostico->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('diagnosticos.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Información del Diagnóstico</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Lote:</th>
                                    <td>{{ $diagnostico->lote ? $diagnostico->lote->numero_lote : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Máquina:</th>
                                    <td>{{ $diagnostico->lote ? $diagnostico->lote->maquina->nombre : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Reportado por:</th>
                                    <td>{{ $diagnostico->usuario->nombre }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha:</th>
                                    <td>{{ $diagnostico->fecha_reporte->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                            
                            <h5 class="mt-3">Descripción del Problema</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $diagnostico->descripcion_problema }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <h5>Cambiar Estado</h5>
                            <form action="{{ route('diagnosticos.update', $diagnostico) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="estado_resolucion">Estado:</label>
                                    <select name="estado_resolucion" id="estado_resolucion" class="form-control" required>
                                        <option value="pendiente" {{ $diagnostico->estado_resolucion == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en_proceso" {{ $diagnostico->estado_resolucion == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="resuelto" {{ $diagnostico->estado_resolucion == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Actualizar Estado
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection