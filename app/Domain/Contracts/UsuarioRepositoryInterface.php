<?php

namespace App\Domain\Contracts;

use App\Models\Usuario;

interface UsuarioRepositoryInterface
{
    public function findByEmail(string $email): ?Usuario;
    public function create(array $data): Usuario;
    public function existsByEmail(string $email): bool;
}
