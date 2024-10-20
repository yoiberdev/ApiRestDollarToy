<?php

namespace app\Validators;

use app\Interfaces\ValidatorInterface;

class UsuarioValidator implements ValidatorInterface
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

        if (isset($filters['id_usuario']) && !is_int($filters['id_usuario'])) {
            $this->error = 'El ID debe ser un número entero';
            return false;
        }

        if (isset($filters['id_rol']) && !is_int($filters['id_rol'])) {
            $this->error = 'El ID debe ser un número entero';
            return false;
        }

        return true;
    }

    public function validateAdd(array $data = []): bool
    {
        if (empty($data)) {
            $this->error = 'Debe proporcionar los datos a crear';
            return false;
        }

        if (empty($data['nombre'])) {
            $this->error = 'El campo nombre es requerido';
            return false;
        }

        if (empty($data['apellido'])) {
            $this->error = 'El campo apellido es requerido';
            return false;
        }

        if (empty($data['email'])) {
            $this->error = 'El campo email es requerido';
            return false;
        }

        if (empty($data['celular'])) {
            $this->error = 'El campo celular es requerido';
            return false;
        }

        if (empty($data['password'])) {
            $this->error = 'El campo passwort es requerido';
            return false;
        }

        if (empty($data['id_rol'])) {
            $this->error = 'El campo id_rol es requerido';
            return false;
        }

        return true;
    }

    public function validateUpdate(array $data): bool
    {
        if (empty($data)) {
            $this->error = 'Debe proporcionar los datos a actualizar';
            return false;
        }

        if (empty($data['id'])) {
            $this->error = 'El campo id es requerido';
            return false;
        }

        if (empty($data['nombre'])) {
            $this->error = 'El campo nombre es requerido';
            return false;
        }

        if (empty($data['apellido'])) {
            $this->error = 'El campo apellido es requerido';
            return false;
        }

        if (empty($data['email'])) {
            $this->error = 'El campo email es requerido';
            return false;
        }

        if (empty($data['celular'])) {
            $this->error = 'El campo celular es requerido';
            return false;
        }

        if (empty($data['password'])) {
            $this->error = 'El campo password es requerido';
            return false;
        }

        if (empty($data['id_rol'])) {
            $this->error = 'El campo id_rol es requerido';
            return false;
        }

        return true;
    }

    public function validateId(?int $id): bool
    {
        if (empty($id)) {
            $this->error = 'Debe proporcionar el ID del usuario a actualizar';
            return false;
        }

        if (!is_int($id)) {
            $this->error = 'El ID debe ser un número entero';
            return false;
        }

        return true;
    }
}