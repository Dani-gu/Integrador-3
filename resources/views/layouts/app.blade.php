<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'MATRIPLAST - Sistema de Gestión Industrial')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Sistema de gestión industrial" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid bg-light pt-3 d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center">
                        <p><i class="fa fa-envelope mr-2"></i>info@matriplast.com</p>
                        <p class="text-body px-3">|</p>
                        <p><i class="fa fa-phone-alt mr-2"></i>+591 123 456 789</p>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-right">
                    @auth
                        <div class="d-inline-flex align-items-center">
                            <span class="text-primary mr-3">
                                <i class="fa fa-user mr-1"></i>{{ Auth::user()->nombre_completo }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-sign-out-alt mr-1"></i>Salir
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-fluid position-relative p-0" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-light navbar-light shadow-lg py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="{{ route('dashboard') }}" class="navbar-brand">
                    <h1 class="m-0 text-primary"><span class="text-dark">MATRI</span>PLAST</h1>
                </a>
                <div class="ml-auto">
                    <span class="text-primary mr-3">
                        <i class="fa fa-user mr-1"></i>{{ Auth::user()->nombre_completo }}
                    </span>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Main Content with Sidebar -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 bg-light p-0" style="min-height: 100vh;">
                <div class="bg-primary text-white p-3">
                    <h6 class="mb-0"><i class="fa fa-user-circle mr-2"></i>{{ Auth::user()->rol->nombre_rol }}</h6>
                    <small>{{ Auth::user()->nombre_completo }}</small>
                </div>
                
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    
                    @if(in_array(Auth::user()->rol->nombre_rol, ['Administrador', 'Supervisor', 'Operario']))
                    <div class="list-group-item bg-secondary text-white py-2">
                        <small><strong>PRODUCCIÓN</strong></small>
                    </div>
                    <a href="{{ route('maquinas.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-cogs mr-2"></i>Máquinas
                    </a>
                    <a href="{{ route('lotes.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-tasks mr-2"></i>Lotes de Producción
                    </a>
                    <a href="{{ route('diagnosticos.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-exclamation-triangle mr-2"></i>Diagnósticos
                    </a>
                    @endif
                    
                    @if(in_array(Auth::user()->rol->nombre_rol, ['Administrador', 'Almacenista', 'Contador']))
                    <div class="list-group-item bg-secondary text-white py-2">
                        <small><strong>INVENTARIO</strong></small>
                    </div>
                    <a href="{{ route('materia-prima.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-boxes mr-2"></i>Materia Prima
                    </a>
                    <a href="{{ route('productos.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-cube mr-2"></i>Productos Terminados
                    </a>
                    <a href="{{ route('movimientos.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-exchange-alt mr-2"></i>Movimientos
                    </a>
                    @endif
                    
                    @if(in_array(Auth::user()->rol->nombre_rol, ['Administrador', 'Vendedor', 'Gerente']))
                    <div class="list-group-item bg-secondary text-white py-2">
                        <small><strong>VENTAS</strong></small>
                    </div>
                    <a href="{{ route('clientes.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-users mr-2"></i>Clientes
                    </a>
                    <a href="{{ route('pedidos.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-shopping-cart mr-2"></i>Pedidos
                    </a>
                    <a href="{{ route('facturas.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-file-invoice mr-2"></i>Facturas
                    </a>
                    @endif
                    
                    @if(Auth::user()->rol->nombre_rol == 'Administrador')
                    <div class="list-group-item bg-secondary text-white py-2">
                        <small><strong>ADMINISTRACIÓN</strong></small>
                    </div>
                    <a href="{{ route('usuarios.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-users-cog mr-2"></i>Usuarios
                    </a>
                    <a href="{{ route('roles.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-shield-alt mr-2"></i>Roles
                    </a>
                    <a href="{{ route('logs.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-history mr-2"></i>Logs del Sistema
                    </a>
                    <a href="{{ route('reportes.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-chart-bar mr-2"></i>Reportes
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 p-0">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 py-3 px-sm-3 px-lg-5">
        <div class="row">
            <div class="col-12 text-center">
                <p class="m-0 text-white-50">Copyright &copy; MATRIPLAST {{ date('Y') }}. Sistema de Gestión Industrial.</p>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>