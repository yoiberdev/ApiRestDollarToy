<?php

namespace app\Business\Producto;

use app\exceptions\DataException;
use app\Interfaces\ProductoInterface;
use app\Models\Producto;
use app\Validators\ProductoValidator;

class ProductoGet
{
    private ProductoInterface $producto;
    private ProductoValidator $validator;

    public function __construct(ProductoInterface $producto, ProductoValidator $validator)
    {
        $this->producto = $producto;
        $this->validator = $validator;
    }

    public function find(array $filters): array
    {
        if (!$this->validator->validateFind($filters)) {
            throw new DataException($this->validator->getError());
        }

        $products = $this->producto->find($filters);

        if (empty($products)) {
            if (isset($filters['id_producto'])) {
                throw new DataException('Producto con id ' . $filters['id_producto'] . ' no encontrado');
            }
            if (isset($filters['id_categoria'])) {
                throw new DataException('No se encontró ningún producto con la categoría con id ' . $filters['id_categoria']);
            }
            if (isset($filters['nombre'])) {
                throw new DataException('No se encontró ningún producto con el nombre "' . $filters['nombre'] . '"');
            }
            if (isset($filters['precio_min']) && isset($filters['precio_max'])) {
                throw new DataException('No se encontró ningún producto con el precio entre ' . $filters['precio_min'] . ' y ' . $filters['precio_max']);
            }
            if (isset($filters['id_sede'])) {
                throw new DataException('No se encontró ningún producto de la sede con id ' . $filters['id_sede']);
            }

            throw new DataException('No hay productos disponibles que coincidan con los criterios');
        }

        return $products;
    }
}