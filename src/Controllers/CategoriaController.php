<?php

namespace app\Controllers;

use app\Business\Categoria\CategoriaAdd;
use app\Business\Categoria\CategoriaGet;
use app\Business\Categoria\CategoriaUpdate;
use app\Business\Categoria\CategoriaDelete;
use app\Data\CategoriaRepository;
use app\Validators\CategoriaValidator;

class CategoriaController
{
    private CategoriaAdd $create;
    private CategoriaGet $get;
    private CategoriaUpdate $update;
    private CategoriaDelete $delete;

    public function __construct(
        CategoriaAdd $create,
        CategoriaGet $get,
        CategoriaUpdate $update,
        CategoriaDelete $delete
    ) {
        $this->create = $create;
        $this->get = $get;
        $this->update = $update;
        $this->delete = $delete;
    }

    public function handleRequest(string $method, array $data): string
    {
        switch ($method) {
            case 'find':
                $result = $this->get->find($data);
                return json_encode($result);

            case 'create':
                $result = $this->create->add($data);
                return json_encode(['message' => 'Categoria creado exitosamente', 'data' => $result]);

            case 'update':
                $result =$this->update->updateById($data['id'], $data);
                return json_encode(['message' => $result]);

            case 'delete':
                $this->delete->deleteById($data['id']);
                return json_encode(['message' => 'Categoria eliminado exitosamente']);

            default:
                return json_encode(['error' => 'Método no soportado']);
        }
    }

    public static function createInstance(): self
    {
        $repository = new CategoriaRepository();
        $validator = new CategoriaValidator();

        return new self(
            new CategoriaAdd($repository, $validator),
            new CategoriaGet($repository, $validator),
            new CategoriaUpdate($repository, $validator),
            new CategoriaDelete($repository)
        );
    }
}