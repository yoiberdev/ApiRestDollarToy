<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

$baseUri = '/ApiRestDollarToy/api';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($uri, $baseUri) === 0) {
    $uri = substr($uri, strlen($baseUri));
}

$url = array_values(array_filter(explode('/', $uri)));

if (!isset($url[0])) {
    echo json_encode(['message' => 'Inicio']);
    exit;
}

switch ($url[0]) {
    case 'roles':
        require __DIR__ . '/Routes/rolesRoutes.php';
        break;

    case 'categorias':
        require __DIR__ . '/Routes/categoriasRoutes.php';
        break;

    case 'login':
    case 'usuarios':
        require __DIR__ . '/Routes/usuariosRoutes.php';
        break;

    case 'productos':
        require __DIR__ . '/Routes/productosRoutes.php';
        break;

    default:
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Route not found']);
        exit;
}
