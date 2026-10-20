@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalle del Diagnóstico #{{ $diagnostico->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('diagnosticos.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Información del Reporte</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $diagnostico->id }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha Reporte:</th>
                                    <td>{{ $diagnostico->fecha_reporte->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Usuario Reporta:</th>
                                    <td>{{ $diagnostico->usuario->nombre }}</td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        <span class="badge badge-{{ $diagnostico->estado_resolucion == 'resuelto' ? 'success' : ($diagnostico->estado_resolucion == 'en_proceso' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($diagnostico->estado_resolucion) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Información del Lote</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Lote:</th>
                                    <td>{{ $diagnostico->lote->numero_lote }}</td>
                                </tr>
                                <tr>
                                    <th>Máquina:</th>
                                    <td>{{ $diagnostico->lote->maquina->nombre }}</td>
                                </tr>
                                <tr>
                                    <th>Falla Detectada:</th>
                                    <td>{{ $diagnostico->falla ? $diagnostico->falla->nombre_falla : 'No especificada' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Descripción del Problema</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $diagnostico->descripcion_problema }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($diagnostico->falla)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Solución Recomendada</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $diagnostico->falla->solucion_recomendada }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(in_array(Auth::user()->rol->nombre_rol, ['Administrador', 'Supervisor']))
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Cambiar Estado</h5>
                            <form action="{{ route('diagnosticos.estado', $diagnostico) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <select name="estado_resolucion" class="form-control" style="width: 200px; display: inline-block;">
                                        <option value="pendiente" {{ $diagnostico->estado_resolucion == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en_proceso" {{ $diagnostico->estado_resolucion == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="resuelto" {{ $diagnostico->estado_resolucion == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary ml-2">Actualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection