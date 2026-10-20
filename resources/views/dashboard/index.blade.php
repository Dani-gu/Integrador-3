@extends('layouts.app')

@section('title', 'Dashboard - MATRIPLAST')

@section('content')
<!-- Hero Section -->
<div class="bg-primary py-4 mb-4">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-12">
                <h3 class="text-white mb-2">
                    Bienvenido al Sistema MATRIPLAST
                </h3>
                <p class="text-white-50 mb-0">
                    Panel de Control - {{ Auth::user()->rol->nombre_rol }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="container-fluid py-4">
    <div class="container-fluid">
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Estadísticas</h6>
            <h1>Panel de Control</h1>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="service-item bg-white text-center p-4 shadow">
                    <div class="d-flex align-items-center justify-content-center bg-primary mx-auto mb-4" 
                         style="width: 90px; height: 90px; border-radius: 50px;">
                        <i class="fa fa-2x fa-users text-white"></i>
                    </div>
                    <h5 class="mb-2">Total Usuarios</h5>
                    <h2 class="text-primary">{{ $totalUsuarios }}</h2>
                    <p class="m-0">Usuarios registrados en el sistema</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="service-item bg-white text-center p-4 shadow">
                    <div class="d-flex align-items-center justify-content-center bg-success mx-auto mb-4" 
                         style="width: 90px; height: 90px; border-radius: 50px;">
                        <i class="fa fa-2x fa-cogs text-white"></i>
                    </div>
                    <h5 class="mb-2">Máquinas</h5>
                    <h2 class="text-success">{{ $totalMaquinas }}</h2>
                    <p class="m-0">Máquinas en el sistema</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="service-item bg-white text-center p-4 shadow">
                    <div class="d-flex align-items-center justify-content-center bg-warning mx-auto mb-4" 
                         style="width: 90px; height: 90px; border-radius: 50px;">
                        <i class="fa fa-2x fa-play text-white"></i>
                    </div>
                    <h5 class="mb-2">Lotes Activos</h5>
                    <h2 class="text-warning">{{ $lotesActivos }}</h2>
                    <p class="m-0">Lotes en producción</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="service-item bg-white text-center p-4 shadow">
                    <div class="d-flex align-items-center justify-content-center bg-info mx-auto mb-4" 
                         style="width: 90px; height: 90px; border-radius: 50px;">
                        <i class="fa fa-2x fa-check-circle text-white"></i>
                    </div>
                    <h5 class="mb-2">Máquinas Operativas</h5>
                    <h2 class="text-info">{{ $maquinasOperativas }}</h2>
                    <p class="m-0">Máquinas funcionando</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="container-fluid py-4 bg-light">
    <div class="container-fluid">
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Acciones Rápidas</h6>
            <h1>Módulos del Sistema</h1>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2 shadow">
                    <img class="img-fluid" src="{{ asset('img/package-1.jpg') }}" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0"><i class="fa fa-cogs text-primary mr-2"></i>Producción</small>
                            <small class="m-0"><i class="fa fa-users text-primary mr-2"></i>Operarios</small>
                        </div>
                        <a class="h5 text-decoration-none" href="#">Gestión de Producción</a>
                        <p class="text-muted mt-2">Control de máquinas, lotes y parámetros de producción</p>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-primary btn-sm">Acceder</a>
                                <small class="text-muted">Módulo Principal</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2 shadow">
                    <img class="img-fluid" src="{{ asset('img/package-2.jpg') }}" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0"><i class="fa fa-boxes text-primary mr-2"></i>Inventario</small>
                            <small class="m-0"><i class="fa fa-warehouse text-primary mr-2"></i>Almacén</small>
                        </div>
                        <a class="h5 text-decoration-none" href="#">Control de Inventario</a>
                        <p class="text-muted mt-2">Gestión de materia prima y productos terminados</p>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-primary btn-sm">Acceder</a>
                                <small class="text-muted">Almacenista</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2 shadow">
                    <img class="img-fluid" src="{{ asset('img/package-3.jpg') }}" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0"><i class="fa fa-chart-line text-primary mr-2"></i>Ventas</small>
                            <small class="m-0"><i class="fa fa-handshake text-primary mr-2"></i>Clientes</small>
                        </div>
                        <a class="h5 text-decoration-none" href="#">Sistema de Ventas</a>
                        <p class="text-muted mt-2">Gestión de pedidos, clientes y facturación</p>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-primary btn-sm">Acceder</a>
                                <small class="text-muted">Vendedor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2 shadow">
                    <img class="img-fluid" src="{{ asset('img/package-4.jpg') }}" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0"><i class="fa fa-brain text-primary mr-2"></i>Sistema Experto</small>
                            <small class="m-0"><i class="fa fa-tools text-primary mr-2"></i>Diagnóstico</small>
                        </div>
                        <a class="h5 text-decoration-none" href="#">Diagnóstico de Fallas</a>
                        <p class="text-muted mt-2">Sistema experto para detección y solución de problemas</p>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-primary btn-sm">Acceder</a>
                                <small class="text-muted">Supervisor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2 shadow">
                    <img class="img-fluid" src="{{ asset('img/package-5.jpg') }}" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0"><i class="fa fa-users-cog text-primary mr-2"></i>Usuarios</small>
                            <small class="m-0"><i class="fa fa-shield-alt text-primary mr-2"></i>Roles</small>
                        </div>
                        <a class="h5 text-decoration-none" href="#">Gestión de Usuarios</a>
                        <p class="text-muted mt-2">Administración de usuarios y control de acceso</p>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-primary btn-sm">Acceder</a>
                                <small class="text-muted">Administrador</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2 shadow">
                    <img class="img-fluid" src="{{ asset('img/package-6.jpg') }}" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0"><i class="fa fa-history text-primary mr-2"></i>Auditoría</small>
                            <small class="m-0"><i class="fa fa-search text-primary mr-2"></i>Trazabilidad</small>
                        </div>
                        <a class="h5 text-decoration-none" href="#">Logs del Sistema</a>
                        <p class="text-muted mt-2">Registro de actividades y trazabilidad completa</p>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-primary btn-sm">Acceder</a>
                                <small class="text-muted">Administrador</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection