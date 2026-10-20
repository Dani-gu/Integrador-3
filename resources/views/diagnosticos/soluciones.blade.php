@extends('layouts.app')

@section('title', 'Buscar Soluciones')

@section('content')
<div class="container-fluid py-4">
    <h2><i class="fa fa-search mr-2"></i>Base de Conocimiento - Soluciones</h2>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('soluciones.buscar') }}">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="q" class="form-control" 
                               placeholder="Buscar por síntoma, causa o solución..." 
                               value="{{ request('q') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fa fa-search mr-1"></i>Buscar
                        </button>
                        <a href="{{ route('soluciones.buscar') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($query) && $query)
        <div class="alert alert-info">
            Resultados para: <strong>"{{ $query }}"</strong>
        </div>
    @endif

    <div class="row">
        @forelse($soluciones ?? [] as $solucion)
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0"><i class="fa fa-exclamation-triangle mr-2"></i>Falla #{{ $solucion->id }}</h6>
                </div>
                <div class="card-body">
                    <h6 class="text-primary">Síntoma:</h6>
                    <p>{{ $solucion->sintoma_descripcion }}</p>
                    
                    @if($solucion->causa_probable)
                    <h6 class="text-warning">Causa Probable:</h6>
                    <p>{{ $solucion->causa_probable }}</p>
                    @endif
                    
                    <h6 class="text-success">Solución Recomendada:</h6>
                    <p>{{ $solucion->recomendacion_solucion }}</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">
                        <i class="fa fa-clock mr-1"></i>
                        Actualizado: {{ $solucion->updated_at->format('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                @if(isset($query) && $query)
                    No se encontraron soluciones para "{{ $query }}"
                @else
                    <h5>Base de Conocimiento de Fallas</h5>
                    <p>Utiliza el buscador para encontrar soluciones a problemas específicos.</p>
                    <p><strong>Ejemplos de búsqueda:</strong></p>
                    <ul class="list-unstyled">
                        <li>• "temperatura alta"</li>
                        <li>• "presión baja"</li>
                        <li>• "vibración"</li>
                        <li>• "ruido extraño"</li>
                    </ul>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('diagnosticos.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left mr-1"></i>Volver a Diagnósticos
        </a>
    </div>
</div>
@endsection