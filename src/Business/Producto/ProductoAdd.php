<?php

namespace app\Business\Producto;

use app\exceptions\DataException;
use app\Interfaces\ValidatorInterface;
use app\Interfaces\CategoriaInterface;
use app\Interfaces\ProductoInterface;
use app\Interfaces\SedeInterface;
use app\Exceptions\ValidationException;
use app\Models\SedeProducto;
use app\Models\Producto;

class ProductoAdd
{
    private ProductoInterface $producto;
    private ValidatorInterface $validator;
    private CategoriaInterface $categoria;
    private SedeInterface $sede;

    public function __construct(ProductoInterface $producto, ValidatorInterface $validator, CategoriaInterface $categoria, SedeInterface $sede)
    {
        $this->producto = $producto;
        $this->validator = $validator;
        $this->categoria = $categoria;
        $this->sede = $sede;
    }

    public function add(array $data)
    {
        if (!$this->validator->validateAdd($data)) {
            throw new ValidationException($this->validator->getError());
        }

        if (!$this->categoria->exists($data['id_categoria_producto'])) {
            throw new DataException('Categoria con id '.$data['id_categoria_producto'].' no encontrado');
        }

        if (!$this->sede->exists($data['id_sede'])) {
            throw new DataException('Sede con id '.$data['id_sede'].' no encontrado');
        }

        $producto = new Producto(
            0, 
            $data['nombre'], 
            $data['descripcion'], 
            $data['precio'], 
            $data['imagen_url'], 
            $data['id_categoria_producto']
        );

        //condicion para validar que el id_sede existe



        $sedeProducto = new SedeProducto($data['id_sede'], 0, $data['stock_disponible']);

        return $this->producto->save($producto, $sedeProducto);
    }
}