@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-users mr-2"></i>Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i>Nuevo Cliente
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Nombre/Razón Social</th>
                            <th>NIT/CI</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Pedidos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                        <tr>
                            <td><strong>{{ $cliente->nombre_razon_social }}</strong></td>
                            <td>{{ $cliente->nit_ci ?: '-' }}</td>
                            <td>{{ $cliente->telefono ?: '-' }}</td>
                            <td>{{ $cliente->email ?: '-' }}</td>
                            <td>
                                <span class="badge badge-info">{{ $cliente->pedidos_count }}</span>
                            </td>
                            <td>
                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('pedidos.create') }}?cliente={{ $cliente->id }}" class="btn btn-sm btn-success">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay clientes registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection