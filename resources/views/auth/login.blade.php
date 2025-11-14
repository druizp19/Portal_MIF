<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Portal Marketing</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <!-- Lado izquierdo con gradiente -->
    <div class="left-side">
        <div class="brand-content">
            <div class="brand-logo">
                <img src="{{ asset('images/logo-medifarma.png') }}" alt="Medifarma">
            </div>
            <h1 class="brand-title">Portal Marketing</h1>
            <p class="brand-subtitle">Sistema de Gestión</p>
        </div>
    </div>

    <!-- Lado derecho con formulario -->
    <div class="right-side">
        <div class="login-box">
            <div class="login-header">
                <h1>Bienvenido</h1>
                <p>Inicia sesión para continuar</p>
            </div>

            @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <a href="{{ route('auth.microsoft') }}" class="login-button">
                <svg class="microsoft-icon" viewBox="0 0 23 23">
                    <path fill="#f35325" d="M0 0h11v11H0z"/>
                    <path fill="#81bc06" d="M12 0h11v11H12z"/>
                    <path fill="#05a6f0" d="M0 12h11v11H0z"/>
                    <path fill="#ffba08" d="M12 12h11v11H12z"/>
                </svg>
                Iniciar sesión con Microsoft
            </a>

            <div class="divider">
                <span>Acceso seguro</span>
            </div>

            <div class="info-box">
                <p>
                    <strong>🔒 Autenticación corporativa</strong><br>
                    Usa tu cuenta de Medifarma para acceder de forma segura al sistema.
                </p>
            </div>

            <div class="footer">
                &copy; {{ date('Y') }} Medifarma S.A. - Todos los derechos reservados
            </div>
        </div>
    </div>
</body>
</html>
