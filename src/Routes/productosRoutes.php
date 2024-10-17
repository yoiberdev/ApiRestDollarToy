<?php

use app\Controllers\ProductoController;
use app\Exceptions\ValidationException;
use app\Exceptions\DataException;

header('Content-Type: application/json');

try {

    $controller = ProductoController::createInstance();

    $method = $_SERVER['REQUEST_METHOD'];
    $data = [];

    $id = isset($url[1]) ? (int)$url[1] : null;

    switch ($method) {
        case 'GET':
            $filters = [
                'id' => isset($_GET['id']) ? (int)$_GET['id'] : $id ?? null,
                'nombre' => $_GET['nombre'] ?? null,
                'id_categoria' => isset($_GET['id_categoria']) ? (int)$_GET['id_categoria'] : null,
                'id_sede' => isset($_GET['id_sede']) ? (int)$_GET['id_sede'] : null,
                'precio_min' => isset($_GET['precio_min']) ? (float)$_GET['precio_min'] : null,
                'precio_max' => isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : null
            ];

            $productos = $controller->handleRequest('find', $filters);
            echo $productos;
            break;

        case 'POST':
            $body = json_decode(file_get_contents('php://input'), true);
            $result = $controller->handleRequest('create', $body);
            echo $result;
            break;

        case 'PUT':
            $body = json_decode(file_get_contents('php://input'), true);

            $body['id'] = $id ?? null;

            echo $controller->handleRequest('update', $body);
            break;

        case 'DELETE':
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