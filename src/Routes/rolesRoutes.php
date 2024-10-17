<?php

use app\Controllers\RolController;
use app\Exceptions\ValidationException;
use app\Exceptions\DataException;

header('Content-Type: application/json');

try {

    $controller = RolController::createInstance();

    $method = $_SERVER['REQUEST_METHOD'];
    $data = [];

    $id = isset($url[1]) ? (int)$url[1] : null;

    switch ($method) {
        case 'GET':
            $filters = [];

            if ($id) {
                $filters['id_rol'] = $id;
            } else {
                $allowedFilters = ['search', 'id_rol', 'id', 'nombre'];

                foreach ($allowedFilters as $filter) {
                    if (isset($_GET[$filter])) {
                        $filters[$filter === 'id' ? 'id_rol' : $filter] = $filter === 'id' ? (int)$_GET[$filter] : $_GET[$filter];
                    }
                }
            }

            $roles = $controller->handleRequest('find', $filters);
            echo $roles;
            break;

        case 'POST':
            $body = json_decode(file_get_contents('php://input'), true);
            echo $controller->handleRequest('create', $body);
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
