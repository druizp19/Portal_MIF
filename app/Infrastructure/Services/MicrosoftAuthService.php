<?php

namespace App\Infrastructure\Services;

use App\Domain\Contracts\AuthServiceInterface;
use Laravel\Socialite\Facades\Socialite;

class MicrosoftAuthService implements AuthServiceInterface
{
    public function redirectToProvider(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver('microsoft')
            ->stateless()
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleProviderCallback(): array
    {
        try {
            $user = Socialite::driver('microsoft')
                ->stateless()
                ->user();
            
            \Log::info('Usuario de Microsoft obtenido:', [
                'email' => $user->getEmail(),
                'name' => $user->getName()
            ]);
            
            return [
                'email' => $user->getEmail(),
                'name' => $user->getName(),
                'token' => $user->token,
            ];
        } catch (\Exception $e) {
            \Log::error('Error en handleProviderCallback de MicrosoftAuthService: ' . $e->getMessage());
            throw $e;
        }
    }
}
