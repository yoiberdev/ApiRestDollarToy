<?php
$baseImagePath = __DIR__ . '/../../uploads/productos/';

if (isset($url[1]) && $url[0] === 'images') {
    $imageName = $url[1]; // Nombre del archivo de imagen
    $imagePath = $baseImagePath . $imageName;
    var_dump($imagePath);
    if (file_exists($imagePath)) {
        // Obtener la extensión del archivo para determinar el tipo de contenido
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        
        // Establecer el tipo de contenido adecuado según la extensión
        switch (strtolower($extension)) {
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'gif':
                header('Content-Type: image/gif');
                break;
            default:
                header('HTTP/1.1 415 Unsupported Media Type');
                echo json_encode(['error' => 'Unsupported image format']);
                exit;
        }

        // Leer el archivo de imagen
        readfile($imagePath);
        exit;
    } else {
        // Si el archivo no existe
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Image not found 2']);
        exit;
    }
}

// Si no se proporciona un nombre de imagen
header('HTTP/1.1 400 Bad Request');
echo json_encode(['error' => 'No image specified']);
exit;
