<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Medifarma</title>
    <link rel="stylesheet" href="{{ asset('css/sistemas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sistemas-extra.css') }}">
</head>
<body>
    <!-- Splash Screen Oracle -->
    <div id="oracle-splash" class="oracle-splash">
        <video autoplay muted loop playsinline class="oracle-video-bg">
            <source src="{{ asset('210884.mp4') }}" type="video/mp4">
        </video>
        <div class="oracle-overlay"></div>
        <div class="oracle-content">
            <h1 class="oracle-text">ORACULO</h1>
            <div class="oracle-loader">
                <div class="loader-bar"></div>
            </div>
        </div>
    </div>

    <canvas id="particles-canvas"></canvas>
    
    <div class="sistemas-container" id="main-content">
        <!-- Top Bar con Usuario y Logout -->
        <div class="top-bar">
            <div class="user-badge">
                <div class="user-avatar">
                    {{ strtoupper(substr(session('usuario.usuario'), 0, 2)) }}
                </div>
                <div class="user-details">
                    <span class="user-name">{{ session('usuario.usuario') }}</span>
                    <span class="user-email">{{ session('usuario.correo') }}</span>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    <svg class="logout-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <div class="header-logo-title">
                    <h1 class="page-title">Portal Marketing</h1>
                    <img src="{{ asset('images/logo-medifarma.png') }}" alt="Medifarma" class="header-logo">
                </div>
            </div>

            @if(session('error'))
            <div class="alert">
                {{ session('error') }}
            </div>
            @endif

            <div class="sistemas-grid">
                @php
                    $todosLosSistemas = config('sistemas.sistemas');
                @endphp
                
                @foreach($sistemasDisponibles as $nombreSistema)
                    @if(isset($todosLosSistemas[$nombreSistema]))
                        @php
                            $sistema = $todosLosSistemas[$nombreSistema];
                        @endphp
                        <a href="{{ route('sistemas.redirect', $nombreSistema) }}" class="sistema-card">
                            <div class="card-header">
                                <div class="card-icon-wrapper">
                                    {{ $sistema['icono'] }}
                                </div>
                                <span class="card-status">
                                    <span class="status-dot"></span>
                                    Activo
                                </span>
                            </div>
                            <h2 class="card-title">{{ $sistema['nombre'] }}</h2>
                            <p class="card-description">{{ $sistema['descripcion'] }}</p>
                            <p class="card-meta">Hace 2 horas</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </main>
    </div>

    <script src="{{ asset('js/particles.js') }}"></script>
    <script src="{{ asset('js/splash.js') }}"></script>
</body>
</html>
