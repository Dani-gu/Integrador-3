@extends('layouts.app')

@section('title', 'Reportar Problema')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-plus mr-2"></i>Reportar Problema</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('diagnosticos.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="id_lote">Lote de Producción (opcional)</label>
                            <select class="form-control @error('id_lote') is-invalid @enderror" id="id_lote" name="id_lote">
                                <option value="">Problema general (no relacionado a lote específico)</option>
                                @foreach($lotes as $lote)
                                    <option value="{{ $lote->id }}" {{ old('id_lote') == $lote->id ? 'selected' : '' }}>
                                        Lote #{{ $lote->id }} - {{ $lote->maquina->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_lote')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_falla_detectada">Tipo de Falla Conocida (opcional)</label>
                            <select class="form-control @error('id_falla_detectada') is-invalid @enderror" id="id_falla_detectada" name="id_falla_detectada">
                                <option value="">Seleccionar si coincide con alguna falla conocida</option>
                                @foreach($fallas as $falla)
                                    <option value="{{ $falla->id }}" {{ old('id_falla_detectada') == $falla->id ? 'selected' : '' }}>
                                        {{ Str::limit($falla->sintoma_descripcion, 80) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_falla_detectada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion_problema">Descripción del Problema *</label>
                            <textarea class="form-control @error('descripcion_problema') is-invalid @enderror" 
                                      id="descripcion_problema" name="descripcion_problema" rows="5" required 
                                      placeholder="Describe detalladamente el problema observado...">{{ old('descripcion_problema') }}</textarea>
                            @error('descripcion_problema')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Incluye: síntomas observados, cuándo ocurrió, condiciones de la máquina, etc.
                            </small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            <strong>Información:</strong> El reporte será enviado al supervisor para su revisión y asignación de solución.
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('diagnosticos.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i>Reportar Problema
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection