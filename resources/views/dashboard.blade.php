<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Portal Medifarma</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-content">
                <div class="header-left">
                    <img src="{{ asset('images/logo-medifarma.png') }}" alt="Medifarma" class="header-logo">
                    <span class="header-title">PORTAL MEDIFARMA</span>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <p class="user-name">{{ session('usuario.usuario') }}</p>
                        <p class="user-email">{{ session('usuario.correo') }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Contenido principal -->
        <main class="dashboard-main">
            <div class="construction-content">
                <svg class="construction-icon" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
                <h1 class="construction-title">EN CONSTRUCCIÓN</h1>
                <p class="construction-subtitle">Estamos trabajando para traerte algo increíble</p>
                <div class="status-badge">
                    <div class="status-dot"></div>
                    <span class="status-text">Próximamente disponible</span>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
