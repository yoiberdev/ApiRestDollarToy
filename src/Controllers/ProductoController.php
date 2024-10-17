<?php

namespace app\Controllers;

use app\Business\Producto\ProductoAdd;
use app\Business\Producto\ProductoGet;
use app\Business\Producto\ProductoUpdate;
use app\Business\Producto\ProductoDelete;
use app\Data\CategoriaRepository;
use app\Data\ProductoRepository;
use app\Data\SedeRepository;
use app\Validators\ProductoValidator;

class ProductoController
{
    private ProductoAdd $create;
    private ProductoGet $get;
    private ProductoUpdate $update;
    private ProductoDelete $delete;

    public function __construct(
        ProductoAdd $create,
        ProductoGet $get,
        ProductoUpdate $update,
        ProductoDelete $delete
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
                return json_encode(['message' => 'Producto creado exitosamente', 'data' => $result]);

            case 'update':
                $result =$this->update->updateById($data['id'], $data);
                return json_encode(['message' => $result]);

            case 'delete':
                $this->delete->deleteById($data['id']);
                return json_encode(['message' => 'Producto eliminado exitosamente']);

            default:
                return json_encode(['error' => 'Método no soportado']);
        }
    }

    public static function createInstance(): self
    {
        $repository = new ProductoRepository();
        $validator = new ProductoValidator();
        $categoria = new CategoriaRepository();
        $sede = new SedeRepository();

        return new self(
            new ProductoAdd($repository, $validator, $categoria, $sede),
            new ProductoGet($repository, $validator),
            new ProductoUpdate($repository, $validator, $categoria, $sede),
            new ProductoDelete($repository)
        );
    }
}