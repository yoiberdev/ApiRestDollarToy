<?php

namespace app\Auth;

use Firebase\JWT\JWT;
use stdClass;

class JwtAuth
{
    private string $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function generateToken(array $data): string
    {
        $payload = [
            'iss' => 'http://localhost/ApiRestDollarToy/api',
            'iat' => time(),
            'exp' => time() + (60 * 60),
            'data' => $data
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function verifyToken(string $jwt): ?stdClass
    {
        try {
            // Decodifica el JWT
            $decoded = JWT::decode($jwt, new \Firebase\JWT\Key($this->secretKey, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            throw new \Exception('Token inválido: ' . $e->getMessage());
        }
    }
}
