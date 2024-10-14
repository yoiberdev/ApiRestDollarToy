<?php

use app\Controllers\RolController;
use app\Exceptions\ValidationException;
use app\Exceptions\DataException;

header('Content-Type: application/json');

try {

    $controller = RolController::createInstance();

    $method = $_SERVER['REQUEST_METHOD'];
    $data = [];

    switch ($method) {
        case 'GET':
            // Verificar si se solicita un rol específico
            if (isset($_GET['id'])) {
                $data['id'] = (int)$_GET['id'];
                // echo $controller->handleRequest('getById', $data);
            } else {
                echo $controller->handleRequest('get', $data);
            }
            break;

        case 'POST':
            // Obtener el cuerpo de la solicitud
            $body = json_decode(file_get_contents('php://input'), true);
            echo $controller->handleRequest('create', $body);
            break;

        case 'PUT':
            // Obtener el cuerpo de la solicitud
            $body = json_decode(file_get_contents('php://input'), true);
            $data['id'] = (int) $body['id'];
            echo $controller->handleRequest('update', $body);
            break;

        case 'DELETE':
            if (isset($_GET['id'])) {
                $data['id'] = (int) $_GET['id'];
                echo $controller->handleRequest('delete', $data);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID no proporcionado para eliminar']);
            }
            break;

        default:
            http_response_code(405); // Método no permitido
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
