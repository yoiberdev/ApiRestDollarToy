<?php

namespace app\Business\Producto;

use app\Interfaces\CategoriaInterface;
use app\Interfaces\ValidatorInterface;
use app\Interfaces\ProductoInterface;
use app\Exceptions\ValidationException;
use app\exceptions\DataException;
use app\Interfaces\SedeInterface;
use app\Models\SedeProducto;
use app\Models\Producto;

class ProductoUpdate
{
    private ProductoInterface $producto;
    private ValidatorInterface $validator;
    private CategoriaInterface $categoria;
    private ProductoGet $productoGet;
    private SedeInterface $sede;

    public function __construct(ProductoInterface $producto, ValidatorInterface $validator, CategoriaInterface $categoria, ProductoGet $productoGet, SedeInterface $sede)
    {
        $this->producto = $producto;
        $this->validator = $validator;
        $this->categoria = $categoria;
        $this->productoGet = $productoGet;
        $this->sede = $sede;
    }

    public function updateById(int $id = null, array $data = []): string
    {
        if (!$this->validator->validateId($id)) {
            throw new ValidationException($this->validator->getError());
        }

        if (!$this->validator->validateUpdate($data)) {
            throw new ValidationException($this->validator->getError());
        }

        if (!$this->producto->exists((int)$data['id'])) {
            throw new DataException('Producto con id '.$id.' no encontrado');
        }

        if (!$this->categoria->exists($data['id_categoria_producto'])) {
            throw new DataException('Categoria con id '.$data['id_categoria_producto'].' no encontrado');
        }

        if (!$this->sede->exists($data['id_sede'])) {
            throw new DataException('Sede con id '.$data['id_sede'].' no encontrado');
        }

        if (empty($data['imagen_url'])) {
            $producto = $this->productoGet->find(['id_producto' => $data['id']]);
            $data['imagen_url'] = $producto[0]['imagen_url'];
        }

        $producto = new Producto(
            $data['id'],
            $data['nombre'], 
            $data['descripcion'], 
            $data['precio'], 
            $data['imagen_url'], 
            $data['id_categoria_producto']
        );

        $sedeProducto = new SedeProducto($data['id_sede'], $data['id'], $data['stock_disponible']);

        return $this->producto->save($producto, $sedeProducto);
    }
}