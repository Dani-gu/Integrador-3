<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login - MATRIPLAST</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-center py-4">
                        <h1 class="text-white m-0">
                            <span class="text-light">MATRI</span>PLAST
                        </h1>
                        <p class="text-white-50 mt-2 mb-0">Sistema de Gestión Industrial</p>
                    </div>
                    <div class="card-body p-5">
                        <h4 class="text-center mb-4">Iniciar Sesión</h4>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="Ingrese su email" required value="{{ old('email') }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Ingrese su contraseña" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block py-3 mt-4">
                                <i class="fa fa-sign-in-alt mr-2"></i>Ingresar al Sistema
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fa fa-info-circle mr-1"></i>
                                Contacte al administrador para obtener credenciales
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Demo credentials info -->
                <div class="card mt-3 border-info">
                    <div class="card-body text-center py-3">
                        <small class="text-info">
                            <strong>Credenciales de prueba:</strong><br>
                            Admin: admin@matriplast.com / admin123<br>
                            Operario: operario@matriplast.com / operario123
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>