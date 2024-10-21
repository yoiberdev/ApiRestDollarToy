<?php

use app\Controllers\SedeController;
use app\Exceptions\ValidationException;
use app\Exceptions\DataException;
use app\Helpers\FileLogHandler;
use app\Helpers\Log;

try {

    $controller = SedeController::createInstance();

    $logFilePath = 'logs/' . date('Y-m-d') . '-sede-log.txt';
    $logHandler = new FileLogHandler($logFilePath);
    $logger = new Log($logHandler);

    $method = $_SERVER['REQUEST_METHOD'];
    $data = [];

    $id = isset($url[1]) ? (int)$url[1] : null;

    $logger->writeLine('INFO', 'SedeController::handleRequest ' . $method);

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

            $logger->writeLine('INFO', 'SedeController::handleRequest find' . json_encode($filters));
            $sedes = $controller->handleRequest('find', $filters);
            echo $sedes;
            break;

        case 'POST':
            $body = json_decode(file_get_contents('php://input'), true);
            $logger->writeLine('INFO', 'SedeController::handleRequest create ' . json_encode($body));

            echo $controller->handleRequest('create', $body);
            break;

        case 'PUT':
            $body = json_decode(file_get_contents('php://input'), true);
            $logger->writeLine('INFO', 'SedeController::handleRequest update ' . json_encode($body));

            $body['id'] = $id ?? null;

            echo $controller->handleRequest('update', $body);
            break;

        case 'DELETE':
            $data['id'] = $id ?? null;
            $logger->writeLine('INFO', 'SedeController::handleRequest delete ID ' . $data['id']);

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