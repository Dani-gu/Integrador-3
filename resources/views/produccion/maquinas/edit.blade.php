@extends('layouts.app')

@section('title', 'Editar Máquina')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="fa fa-edit mr-2"></i>Editar Máquina</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('maquinas.update', $maquina) }}">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label for="nombre">Nombre de la Máquina</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $maquina->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                <option value="operativa" {{ old('estado', $maquina->estado) == 'operativa' ? 'selected' : '' }}>Operativa</option>
                                <option value="en_mantenimiento" {{ old('estado', $maquina->estado) == 'en_mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                                <option value="fuera_de_servicio" {{ old('estado', $maquina->estado) == 'fuera_de_servicio' ? 'selected' : '' }}>Fuera de Servicio</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('maquinas.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save mr-1"></i>Actualizar Máquina
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection