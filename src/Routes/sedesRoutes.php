<?php

use app\Controllers\SedeController;
use app\Exceptions\ValidationException;
use app\Exceptions\DataException;

try {

    $controller = SedeController::createInstance();

    $method = $_SERVER['REQUEST_METHOD'];
    $data = [];

    $id = isset($url[1]) ? (int)$url[1] : null;

    switch ($method) {
        case 'GET':
            $filters = [];

            if ($id) {
                $filters['id_sede'] = $id;
            } else {
                $allowedFilters = ['search', 'id_sede', 'id', 'nombre', 'direccion', 'ciudad'];

                foreach ($allowedFilters as $filter) {
                    if (isset($_GET[$filter])) {
                        $filters[$filter === 'id' ? 'id_sede' : $filter] = $filter === 'id' ? (int)$_GET[$filter] : $_GET[$filter];
                    }
                }
            }

            $sedes = $controller->handleRequest('find', $filters);
            echo $sedes;
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