<?php

namespace app\Validators;

use app\Interfaces\ValidatorInterface;

class RolValidator implements ValidatorInterface
{
    private string $error;

    public function getError(): string
    {
        return $this->error;
    }

    public function validateAdd(array $data): bool
    {
        if (empty($data['nombre'])) {
            $this->error = 'El campo nombre es requerido';
            return false;
        }
        return true;
    }

    public function validateUpdate(array $data): bool
    {
        if (empty($data['id'])) {
            $this->error = 'El campo id es requerido';
            return false;
        }

        if (empty($data['nombre'])) {
            $this->error = 'El campo nombre es requerido';
            return false;
        }
        return true;
    }
}