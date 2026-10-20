@extends('layouts.app')

@section('title', 'Nueva Máquina')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-plus mr-2"></i>Nueva Máquina</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('maquinas.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre de la Máquina</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                <option value="">Seleccionar estado</option>
                                <option value="operativa" {{ old('estado') == 'operativa' ? 'selected' : '' }}>Operativa</option>
                                <option value="en_mantenimiento" {{ old('estado') == 'en_mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                                <option value="fuera_de_servicio" {{ old('estado') == 'fuera_de_servicio' ? 'selected' : '' }}>Fuera de Servicio</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('maquinas.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i>Guardar Máquina
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection