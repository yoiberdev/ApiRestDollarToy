<?php

use app\Auth\JwtAuth;
use app\Controllers\UsuarioController;
use app\Exceptions\ValidationException;
use app\Exceptions\DataException;
use app\Middleware\JwtMiddleware;

header('Content-Type: application/json');

$jwtAuth = new JwtAuth(getenv('JWT_SECRET_KEY'));
$jwtMiddleware = new JwtMiddleware($jwtAuth);

try {

    $controller = UsuarioController::createInstance();

    $method = $_SERVER['REQUEST_METHOD'];
    $data = [];

    $id = isset($url[1]) ? (int)$url[1] : null;

    switch ($method) {
        case 'GET':
            $jwtMiddleware->authenticate();
            $filters = [
                'id' => isset($_GET['id']) ? (int)$_GET['id'] : $id ?? null,
                'nombre' => $_GET['nombre'] ?? null,
                'apellido' => $_GET['apellido'] ?? null,
                'email' => $_GET['email'] ?? null,
                'id_rol' => isset($_GET['id_rol']) ? (int)$_GET['id_rol'] : null
            ];

            $usuarios = $controller->handleRequest('find', $filters);
            echo $usuarios;
            break;

        case 'POST':
            $body = json_decode(file_get_contents('php://input'), true);
            if ($url[0] === 'login') {
                $result = $controller->login($body);
                
                echo $result;
                break;
            } else {
                $jwtMiddleware->authenticate();
                
                $body['password'] = password_hash($body['password'], PASSWORD_DEFAULT);
    
                echo $controller->handleRequest('create', $body);
            }
            break;

        case 'PUT':
            $jwtMiddleware->authenticate();
            $body = json_decode(file_get_contents('php://input'), true);

            $body['id'] = $id ?? null;

            if (isset($body['password'])) {
                $body['password'] = password_hash($body['password'], PASSWORD_DEFAULT);
            }

            echo $controller->handleRequest('update', $body);
            break;

        case 'DELETE':
            $jwtMiddleware->authenticate();
            $data['id'] = $id ?? null;

            echo $controller->handleRequest('delete', $data);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no soportado']);
            break;
    }
} catch (ValidationException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
} catch (DataException $e) {
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\TypeError $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}