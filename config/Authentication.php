<?php

namespace Config;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class Authentication
{

    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function createCryptoLogin(int $id, string $email): string
    {
        $payload = [
            "iss" => "http://localhost:8080",
            "iat" => time(),
            "exp" => time() + (3600),
            "id" => $id,
            "email" => $email
        ];

        return JWT::encode($payload, $this->key, "HS256");
    }

    public function validateToken(string $token): void
    {
        $token = $this->authVerify($token);

        $user = JWT::decode($token, new Key($this->key, "HS256"));

        if (empty($user)) {
            throw new Exception("Token inválido ou expirado!");
        }
    }

    private function authVerify(string $token): string
    {
        if (!str_starts_with($token, 'Bearer ')) {
            throw new Exception("Token ausente ou inválido!");
        }

        return substr($token, 7);
    }
}
