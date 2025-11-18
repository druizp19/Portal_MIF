<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SSOTokenService
{
    private string $secretKey;
    private int $expirationTime = 300; // 5 minutos

    public function __construct()
    {
        $key = config('app.key');
        
        // Laravel siempre incluye el prefijo base64: en APP_KEY, decodificarlo
        if (str_starts_with($key, 'base64:')) {
            $this->secretKey = base64_decode(substr($key, 7));
        } else {
            $this->secretKey = $key;
        }
    }

    public function generateToken(array $userData): string
    {
        $payload = [
            'iss' => config('app.url'),
            'iat' => time(),
            'exp' => time() + $this->expirationTime,
            'data' => $userData
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function validateToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return (array) $decoded->data;
        } catch (\Exception $e) {
            return null;
        }
    }
}
