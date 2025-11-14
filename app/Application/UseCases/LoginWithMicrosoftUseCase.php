<?php

namespace App\Application\UseCases;

use App\Domain\Contracts\AuthServiceInterface;
use App\Domain\Contracts\UsuarioRepositoryInterface;
use Illuminate\Support\Facades\Session;

class LoginWithMicrosoftUseCase
{
    public function __construct(
        private AuthServiceInterface $authService,
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    public function redirect()
    {
        return $this->authService->redirectToProvider();
    }

    public function handleCallback(): array
    {
        try {
            $microsoftUser = $this->authService->handleProviderCallback();
            
            \Log::info('Microsoft user data:', $microsoftUser);
            
            $email = $microsoftUser['email'] ?? null;
            
            if (!$email) {
                \Log::error('Email no encontrado en respuesta de Microsoft');
                return [
                    'success' => false,
                    'message' => 'No se pudo obtener el correo electrónico de Microsoft.',
                ];
            }

            if (!$this->usuarioRepository->existsByEmail($email)) {
                \Log::warning('Usuario no autorizado: ' . $email);
                return [
                    'success' => false,
                    'message' => 'No tienes acceso al sistema. Por favor contacta al administrador.',
                ];
            }

            $usuario = $this->usuarioRepository->findByEmail($email);
            
            if (!$usuario) {
                \Log::error('Usuario no encontrado en BD: ' . $email);
                return [
                    'success' => false,
                    'message' => 'Error al obtener datos del usuario.',
                ];
            }
            
            // Guardar en sesión
            Session::put('usuario', [
                'idUsuario' => $usuario->idUsuario,
                'correo' => $usuario->correo,
                'usuario' => $usuario->usuario ?? $usuario->correo,
            ]);
            
            Session::save();
            
            \Log::info('Login exitoso para: ' . $email);

            return [
                'success' => true,
                'usuario' => $usuario,
            ];
        } catch (\Exception $e) {
            \Log::error('Error en handleCallback: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return [
                'success' => false,
                'message' => 'Error al procesar la autenticación: ' . $e->getMessage(),
            ];
        }
    }
}
