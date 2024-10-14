<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/config/database.php';

$baseUri = '/ApiRestDollarToy';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($uri, $baseUri) === 0) {
    // Eliminar la base URI de la URI solicitada
    $uri = substr($uri, strlen($baseUri));
}


switch ($uri) {
    case '/api':
    case '/api/roles':
        require __DIR__ . '/Routes/roles.php';
        break;

    case '/usuarios':
        require __DIR__ . '/Routes/usuarios.php';
        break;

    case '/productos':
        require __DIR__ . '/Routes/productos.php';
        break;

    default:
        header('HTTP/1.1 404 Not Found');
        echo ' ';
        break;
}
