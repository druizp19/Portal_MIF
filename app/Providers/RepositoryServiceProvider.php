<?php

namespace App\Providers;

use App\Domain\Contracts\AuthServiceInterface;
use App\Domain\Contracts\UsuarioRepositoryInterface;
use App\Infrastructure\Repositories\UsuarioRepository;
use App\Infrastructure\Services\MicrosoftAuthService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UsuarioRepositoryInterface::class, UsuarioRepository::class);
        $this->app->bind(AuthServiceInterface::class, MicrosoftAuthService::class);
        $this->app->singleton(\App\Services\SSOTokenService::class);
    }

    public function boot(): void
    {
        //
    }
}
