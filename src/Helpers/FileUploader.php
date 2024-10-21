<?php

namespace app\Helpers;

use app\Interfaces\FileUploaderInterface;

class FileUploader implements FileUploaderInterface
{
    public function upload($file, $destinationFolder): string
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            throw new \Exception('No se pudo subir el archivo.');
        }

        $uniqueName = uniqid() . '-' . basename($file['name']);

        if (!is_dir($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }

        $destinationPath = $destinationFolder . DIRECTORY_SEPARATOR . $uniqueName;

        if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
            throw new \Exception('Error al mover el archivo.');
        }

        return $destinationPath;
    }
}