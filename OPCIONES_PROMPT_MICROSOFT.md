# Opciones de Prompt para Microsoft Azure AD

En el archivo `app/Infrastructure/Services/MicrosoftAuthService.php`, puedes cambiar el parámetro `prompt` según tus necesidades:

## Opciones disponibles:

### 1. `prompt=select_account` (RECOMENDADO - YA CONFIGURADO)
```php
->with(['prompt' => 'select_account'])
```
- Muestra la pantalla de selección de cuenta
- Permite elegir entre cuentas guardadas o usar otra
- Mejor experiencia de usuario
- **Uso:** Cuando quieres permitir cambiar de cuenta fácilmente

### 2. `prompt=login`
```php
->with(['prompt' => 'login'])
```
- Siempre pide usuario y contraseña
- No recuerda ninguna sesión anterior
- Más seguro pero menos conveniente
- **Uso:** Para aplicaciones de alta seguridad

### 3. `prompt=consent`
```php
->with(['prompt' => 'consent'])
```
- Pide consentimiento de permisos cada vez
- Útil cuando cambias los permisos de la app
- **Uso:** Desarrollo o cuando actualizas permisos

### 4. `prompt=none`
```php
->with(['prompt' => 'none'])
```
- No muestra ninguna UI
- Falla si no hay sesión activa
- **Uso:** Para SSO silencioso

### 5. Sin prompt (por defecto)
```php
// Sin ->with(['prompt' => '...'])
```
- Usa la sesión existente si está disponible
- Solo pide login si no hay sesión
- **Problema:** No permite cambiar de cuenta fácilmente

## Configuración actual:
Actualmente está configurado con `select_account`, que es la mejor opción para tu caso de uso.

## Para cambiar:
Edita el archivo: `app/Infrastructure/Services/MicrosoftAuthService.php`
Línea: `->with(['prompt' => 'select_account'])`
