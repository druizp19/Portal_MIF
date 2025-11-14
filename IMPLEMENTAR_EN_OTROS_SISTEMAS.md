# Implementación SSO en Otros Sistemas

## Instrucciones para implementar en cada sistema (FFVV, Config Mercado, Plataforma BI)

### 1. Instalar JWT en cada sistema
```bash
composer require firebase/php-jwt
```

### 2. Crear el servicio SSO (app/Services/SSOTokenService.php)
```php
<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SSOTokenService
{
    private string $secretKey;

    public function __construct()
    {
        // IMPORTANTE: Debe ser la misma clave que el portal principal
        $this->secretKey = env('SSO_SECRET_KEY', 'base64:yCoUf37syuy3prwLtoh1voFf8yZ2u43uckDZtDlU63E=');
    }

    public function validateToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            
            // Verificar que no haya expirado
            if ($decoded->exp < time()) {
                return null;
            }
            
            return (array) $decoded->data;
        } catch (\Exception $e) {
            \Log::error('Error validando token SSO: ' . $e->getMessage());
            return null;
        }
    }
}
```

### 3. Crear el controlador SSO (app/Http/Controllers/SSOController.php)
```php
<?php

namespace App\Http\Controllers;

use App\Services\SSOTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User; // O tu modelo de usuario

class SSOController extends Controller
{
    public function __construct(
        private SSOTokenService $ssoTokenService
    ) {}

    public function login(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect('/login')->with('error', 'Token no proporcionado');
        }

        $userData = $this->ssoTokenService->validateToken($token);

        if (!$userData) {
            return redirect('/login')->with('error', 'Token inválido o expirado');
        }

        // El token ya fue validado en el portal principal
        // Solo necesitas crear la sesión con los datos recibidos
        Session::put('usuario', [
            'idUsuario' => $userData['idUsuario'],
            'correo' => $userData['correo'],
            'usuario' => $userData['usuario'],
            'rol' => $userData['rol'] ?? null,
            'idRol' => $userData['idRol'] ?? null,
            'sistema' => $userData['sistema'] ?? null
        ]);

        // Si usas Auth de Laravel, puedes buscar/crear el usuario:
        // $user = User::firstOrCreate(
        //     ['email' => $userData['correo']],
        //     ['name' => $userData['usuario']]
        // );
        // Auth::login($user);

        return redirect('/dashboard'); // O tu ruta principal
    }
}
```

### 4. Agregar ruta en routes/web.php
```php
use App\Http\Controllers\SSOController;

Route::get('/sso/login', [SSOController::class, 'login'])->name('sso.login');
```

### 5. Agregar en .env de cada sistema
```env
SSO_SECRET_KEY=base64:yCoUf37syuy3prwLtoh1voFf8yZ2u43uckDZtDlU63E=
```

**IMPORTANTE:** La clave `SSO_SECRET_KEY` debe ser EXACTAMENTE la misma en todos los sistemas (portal + los 3 sistemas).

### 6. Registrar el servicio en AppServiceProvider o crear un ServiceProvider
```php
// En app/Providers/AppServiceProvider.php
public function register(): void
{
    $this->app->singleton(\App\Services\SSOTokenService::class);
}
```

## Flujo de autenticación:

1. Usuario inicia sesión en Portal Medifarma (localhost:8000)
2. Ve las 3 cards de sistemas
3. Click en un sistema (ej: FFVV)
4. Portal genera token JWT con datos del usuario
5. Redirige a: `http://localhost:8001/sso/login?token=XXXXX`
6. Sistema FFVV valida el token
7. Si es válido, inicia sesión automáticamente
8. Usuario accede directamente sin volver a loguearse

## Seguridad:
- Token expira en 5 minutos
- Token solo se puede usar una vez (opcional: implementar blacklist)
- Misma clave secreta en todos los sistemas
- Validación de usuario en cada sistema

## Notas:
- **NO necesitas tabla de usuarios en cada sistema** - El portal usa la tabla centralizada `ODS.TAB_USUARIO_ROL`
- El token JWT ya incluye toda la información del usuario (id, correo, nombre, rol)
- Cada sistema solo valida el token y crea la sesión con los datos recibidos
- La tabla `ODS.TAB_USUARIO_ROL` controla qué usuarios tienen acceso a qué sistemas
- El portal solo muestra las cards de los sistemas a los que el usuario tiene acceso
