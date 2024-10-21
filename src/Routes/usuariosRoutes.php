<?php

use app\Auth\JwtAuth;
use app\Controllers\UsuarioController;
use app\Exceptions\ValidationException;
use app\Exceptions\DataException;
use app\Helpers\FileLogHandler;
use app\Helpers\Log;
use app\Middleware\JwtMiddleware;

$jwtAuth = new JwtAuth('esta-es-una-clave-super-secreta');
$jwtMiddleware = new JwtMiddleware($jwtAuth);

try {

    $controller = UsuarioController::createInstance();

    $logFilePath = 'logs/' . date('Y-m-d') . '-usuario-log.txt';
    $logHandler = new FileLogHandler($logFilePath);
    $logger = new Log($logHandler);
    
    $method = $_SERVER['REQUEST_METHOD'];
    $data = [];

    $id = isset($url[1]) ? (int)$url[1] : null;

    $logger->writeLine('INFO', 'UsuarioController::handleRequest ' . $method);

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

            $logger->writeLine('INFO', 'UsuarioController::handleRequest find' . json_encode($filters));
            $usuarios = $controller->handleRequest('find', $filters);
            echo $usuarios;
            break;

        case 'POST':
            $body = json_decode(file_get_contents('php://input'), true);
            if ($url[0] === 'login') {
                $result = $controller->login($body);
                
                $logger->writeLine('INFO', 'UsuarioController::handleRequest login ' . json_encode($body));
                
                echo $result;
                break;
            } else {
                $jwtMiddleware->authenticate();
                
                $body['password'] = password_hash($body['password'], PASSWORD_DEFAULT);

                $logger->writeLine('INFO', 'UsuarioController::handleRequest create ' . json_encode($body));
            
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
            $logger->writeLine('INFO', 'UsuarioController::handleRequest update ' . json_encode($body));
            
            echo $controller->handleRequest('update', $body);
            break;

        case 'DELETE':
            $jwtMiddleware->authenticate();
            $data['id'] = $id ?? null;
            $logger->writeLine('INFO', 'UsuarioController::handleRequest delete ID ' . $data['id']);

            echo $controller->handleRequest('delete', $data);
            break;

        default:
            $logger->writeLine('ERROR', 'Método no soportado: ' . $method);
            http_response_code(405);
            echo json_encode(['error' => 'Método no soportado']);
            break;
    }
} catch (ValidationException $e) {
    $logger->writeLine('ERROR', 'ValidationException: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
} catch (DataException $e) {
    $logger->writeLine('ERROR', 'DataException: ' . $e->getMessage());
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\PDOException $e) {
    $logger->writeLine('ERROR', 'PDOException: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\Exception $e) {
    $logger->writeLine('ERROR', 'Exception: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\TypeError $e) {
    $logger->writeLine('ERROR', 'TypeError: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}