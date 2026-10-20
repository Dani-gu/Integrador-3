@extends('layouts.app')

@section('title', 'Nuevo Lote de Producción')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-plus mr-2"></i>Nuevo Lote de Producción</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('lotes.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="id_maquina">Máquina</label>
                            <select class="form-control @error('id_maquina') is-invalid @enderror" id="id_maquina" name="id_maquina" required>
                                <option value="">Seleccionar máquina</option>
                                @foreach($maquinas as $maquina)
                                    <option value="{{ $maquina->id }}" {{ old('id_maquina') == $maquina->id ? 'selected' : '' }}>
                                        {{ $maquina->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_maquina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_operario">Operario</label>
                            <select class="form-control @error('id_operario') is-invalid @enderror" id="id_operario" name="id_operario" required>
                                <option value="">Seleccionar operario</option>
                                @foreach($operarios as $operario)
                                    <option value="{{ $operario->id }}" {{ old('id_operario') == $operario->id ? 'selected' : '' }}>
                                        {{ $operario->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_operario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cantidad_producida">Cantidad Inicial (opcional)</label>
                            <input type="number" class="form-control @error('cantidad_producida') is-invalid @enderror" 
                                   id="cantidad_producida" name="cantidad_producida" value="{{ old('cantidad_producida', 0) }}" min="0">
                            @error('cantidad_producida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('lotes.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-play mr-1"></i>Iniciar Lote
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection