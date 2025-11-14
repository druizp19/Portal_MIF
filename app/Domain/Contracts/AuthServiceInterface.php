<?php

namespace App\Domain\Contracts;

interface AuthServiceInterface
{
    public function redirectToProvider(): \Symfony\Component\HttpFoundation\RedirectResponse;
    public function handleProviderCallback(): array;
}
