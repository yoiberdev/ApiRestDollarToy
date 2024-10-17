<?php

namespace app\Validators;

use app\Interfaces\ValidatorInterface;

class ProductoValidator implements ValidatorInterface
{
    private string $error;

    public function getError(): string
    {
        return $this->error;
    }

    public function validateFind(array $filters): bool
    {
        if (isset($filters['search']) && empty($filters['search'])) {
            $this->error = 'El parámetro search no puede estar vacío';
            return false;
        }

        if (isset($filters['id_producto']) && !is_int($filters['id_producto'])) {
            $this->error = 'El ID del producto debe ser un número entero';
            return false;
        }

        if (isset($filters['id_categoria']) && !is_int($filters['id_categoria'])) {
            $this->error = 'El ID de la categoría debe ser un número entero';
            return false;
        }

        if (isset($filters['id_sede']) && !is_int($filters['id_sede'])) {
            $this->error = 'El ID del sede debe ser un número entero';
            return false;
        }

        return true;
    }

    public function validateAdd(array $data = []): bool
    {
        if (empty($data)) {
            $this->error = 'Debe proporcionar los datos del producto a crear';
            return false;
        }

        if (empty($data['nombre'])) {
            $this->error = 'El campo nombre es requerido';
            return false;
        }

        if (empty($data['descripcion'])) {
            $this->error = 'El campo descripcion es requerido';
            return false;
        }

        if (empty($data['precio']) || !is_numeric($data['precio'])) {
            $this->error = 'El campo precio es requerido y debe ser un número válido';
            return false;
        }

        if (empty($data['id_categoria_producto']) || !is_int($data['id_categoria_producto'])) {
            $this->error = 'El campo id_categoria es requerido y debe ser un número entero';
            return false;
        }

        return true;
    }

    public function validateUpdate(array $data): bool
    {
        if (empty($data)) {
            $this->error = 'Debe proporcionar los datos del producto a actualizar';
            return false;
        }

        if (empty($data['id'])) {
            $this->error = 'El campo id es requerido';
            return false;
        }

        if (!is_int($data['id'])) {
            $this->error = 'El ID del producto debe ser un número entero';
            return false;
        }

        if (empty($data['nombre'])) {
            $this->error = 'El campo nombre es requerido';
            return false;
        }

        if (empty($data['descripcion'])) {
            $this->error = 'El campo descripcion es requerido';
            return false;
        }

        if (empty($data['precio']) || !is_numeric($data['precio'])) {
            $this->error = 'El campo precio es requerido y debe ser un número válido';
            return false;
        }
        
        if (empty($data['id_categoria_producto']) || !is_int($data['id_categoria_producto'])) {
            $this->error = 'El campo id_categoria es requerido y debe ser un número entero';
            return false;
        }

        if (empty($data['id_sede']) || !is_int($data['id_sede'])) {
            $this->error = 'El campo id_sede es requerido y debe ser un número entero';
            return false;
        }

        if (empty($data['stock_disponible']) || !is_int($data['stock_disponible'])) {
            $this->error = 'El campo stock_disponible es requerido y debe ser un número entero';
            return false;
        }

        return true;
    }

    public function validateId(?int $id): bool
    {
        if (empty($id)) {
            $this->error = 'Debe proporcionar el ID del producto';
            return false;
        }

        if (!is_int($id)) {
            $this->error = 'El ID debe ser un número entero';
            return false;
        }

        return true;
    }
}
