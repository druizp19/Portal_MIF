<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Contracts\UsuarioRepositoryInterface;
use App\Models\Usuario;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    public function findByEmail(string $email): ?Usuario
    {
        return Usuario::where('correo', $email)->first();
    }

    public function create(array $data): Usuario
    {
        return Usuario::create($data);
    }

    public function existsByEmail(string $email): bool
    {
        return Usuario::where('correo', $email)->exists();
    }
}
