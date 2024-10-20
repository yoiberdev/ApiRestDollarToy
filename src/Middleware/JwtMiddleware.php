<?php

namespace app\Middleware;

use app\Auth\JwtAuth;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

class JwtMiddleware
{
    private JwtAuth $jwtAuth;

    public function __construct(JwtAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function authenticate(): void
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(['error' => 'Token no proporcionado']);
            exit;
        }

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            http_response_code(401);
            echo json_encode(['error' => 'Formato de token no válido']);
            exit;
        }

        $token = $matches[1];

        try {
            $decoded = $this->jwtAuth->verifyToken($token);
            // Aquí se puede añadir datos del usuario decodificado a la solicitud
            // Por ejemplo guardar en $_SESSION
            $_SESSION['user'] = (array) $decoded->data;
        } catch (ExpiredException $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Token expirado']);
            exit;
        } catch (SignatureInvalidException $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Firma de token inválida']);
            exit;
        } catch (BeforeValidException $e) {
            http_response_code(401);
            echo json_encode(['error' => 'El token no es válido aún']);
            exit;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido: ' . $e->getMessage()]);
            exit;
        }
    }
}
