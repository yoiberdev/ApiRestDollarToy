<?php

use app\Controllers\ProductoController;
use app\Exceptions\ValidationException;
use app\Exceptions\DataException;
use app\Helpers\FileLogHandler;
use app\Helpers\FileUploader;
use app\Helpers\Log;

try {

    $controller = ProductoController::createInstance();

    // $logFilePath = 'logs/' . date('Y-m-d') . '-producto-log.txt';
    // $logHandler = new FileLogHandler($logFilePath);
    // $logger = new Log($logHandler);

    $fileUploader = new FileUploader();
    $destinationFolder = 'uploads/productos';

    $method = $_SERVER['REQUEST_METHOD'];
    $data = [];

    $id = isset($url[1]) ? (int)$url[1] : null;

    // $logger->writeLine('INFO', 'ProductoController::handleRequest ' . $method);

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

            // $logger->writeLine('INFO', 'ProductoController::handleRequest find' . json_encode($filters));
            $productos = $controller->handleRequest('find', $filters);
            $productoData = json_decode($productos, true);

            //arramap para cambiar la url de la imagen de cada indice
            $productoData = array_map(function ($producto) {
                $producto['imagen_url'] = 'http://localhost/ApiRestDollarToy/api/images/' . basename($producto['imagen_url']);
                return $producto;
            }, $productoData);

            echo json_encode($productoData);
            break;

        case 'POST':
            $body = [
                'id' => $id ? $id : $_POST['id'] ?? null,
                'nombre' => $_POST['nombre'] ?? null,
                'descripcion' => $_POST['descripcion'] ?? null,
                'precio' => isset($_POST['precio']) ? (float)$_POST['precio'] : null,
                'id_categoria_producto' => isset($_POST['id_categoria_producto']) ? (int)$_POST['id_categoria_producto'] : null,
                'id_sede' => isset($_POST['id_sede']) ? (int)$_POST['id_sede'] : null,
                'stock_disponible' => isset($_POST['stock_disponible']) ? (int)$_POST['stock_disponible'] : null,
                'operacion' => $_POST['operacion'] ?? null,
            ];

            if (isset($_FILES['imagen'])) {
                $filePath = $fileUploader->upload($_FILES['imagen'], $destinationFolder);
                $body['imagen_url'] = $filePath;
            } else {
                $body['imagen_url'] = null;
            }

            // $logger->writeLine('INFO', 'ProductoController::handleRequest create ' . json_encode($body));

            if ($id === null) {
                $result = $controller->handleRequest('create', $body);
            } else {
                $result = $controller->handleRequest('update', $body);
            }

            echo $result;
            break;

        case 'PUT':
            $body = [
                'id' => $id ? $id : $_POST['id'] ?? null,
                'nombre' => $_POST['nombre'] ?? null,
                'descripcion' => $_POST['descripcion'] ?? null,
                'precio' => isset($_POST['precio']) ? (float)$_POST['precio'] : null,
                'id_categoria_producto' => isset($_POST['id_categoria_producto']) ? (int)$_POST['id_categoria_producto'] : null,
                'id_sede' => isset($_POST['id_sede']) ? (int)$_POST['id_sede'] : null,
                'stock_disponible' => isset($_POST['stock_disponible']) ? (int)$_POST['stock_disponible'] : null,
                'operacion' => $_POST['operacion'] ?? null,
            ];

            if (isset($body['imagen'])) {
                $filePath = $fileUploader->upload($body['imagen'], $destinationFolder);
                $body['imagen_url'] = $filePath;
            }

            // $logger->writeLine('INFO', 'ProductoController::handleRequest update ' . json_encode($body));

            $body['id'] = $id ?? null;

            echo $controller->handleRequest('update', $body);
            break;

        case 'DELETE':
            $data['id'] = $id ?? null;
            // $logger->writeLine('INFO', 'ProductoController::handleRequest delete ID ' . $data['id']);

            echo $controller->handleRequest('delete', $data);
            break;

        default:
            // $logger->writeLine('ERROR', 'Método no soportado: ' . $method);
            http_response_code(405);
            echo json_encode(['error' => 'Método no soportado']);
            break;
    }
} catch (ValidationException $e) {
    // $logger->writeLine('ERROR', 'ValidationException: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
} catch (DataException $e) {
    // $logger->writeLine('ERROR', 'DataException: ' . $e->getMessage());
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\PDOException $e) {
    // $logger->writeLine('ERROR', 'PDOException: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\Exception $e) {
    // $logger->writeLine('ERROR', 'Exception: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\TypeError $e) {
    // $logger->writeLine('ERROR', 'TypeError: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
