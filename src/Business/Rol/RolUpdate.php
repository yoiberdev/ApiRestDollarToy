<?php

namespace app\Business\Rol;

use app\Interfaces\ValidatorInterface;
use app\Interfaces\RolInterface;
use app\Exceptions\ValidationException;
use app\exceptions\DataException;

class RolUpdate
{
    private RolInterface $rol;
    private ValidatorInterface $validator;

    public function __construct(RolInterface $rol, ValidatorInterface $validator)
    {
        $this->rol = $rol;
        $this->validator = $validator;
    }

    public function updateById(int $id, array $data): string
    {
        if (!$this->validator->validateUpdate($data)) {
            throw new ValidationException($this->validator->getError());
        }

        if (!$this->rol->exists((int)$data['id'])) {
            throw new DataException('Rol con id '.$id.' no encontrado');
        }

        $rol = $this->rol->getById($id);

        return "Rol con id ".$rol->getId()." actualizado con éxito";
    }
}