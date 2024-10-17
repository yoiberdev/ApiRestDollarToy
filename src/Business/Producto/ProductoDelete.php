<?php

namespace app\Business\Producto;

use app\exceptions\DataException;
use app\Interfaces\ProductoInterface;

class ProductoDelete
{
    private ProductoInterface $producto;

    public function __construct(ProductoInterface $producto)
    {
        $this->producto = $producto;
    }

    public function deleteById(int $id = null): bool
    {
        if (!$id) {
            throw new DataException('Debe proporcionar el ID del producto a eliminar');
        }

        if (!$producto = $this->producto->exists($id)) {
            throw new DataException('Producto con id '.$id.' no encontrado');
        }

        return $this->producto->delete($id);
    }
}