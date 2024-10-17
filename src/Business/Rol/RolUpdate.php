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

    public function updateById(int $id = null, array $data = []): string
    {
        if (!$this->validator->validateId($id)) {
            throw new ValidationException($this->validator->getError());
        }

        if (!$this->validator->validateUpdate($data)) {
            throw new ValidationException($this->validator->getError());
        }

        if (!$this->rol->exists((int)$data['id'])) {
            throw new DataException('Rol con id '.$id.' no encontrado');
        }

        $rol = $this->rol->find(['id_rol' => $id]);

        $this->rol->update($rol[0]);

        return "Rol con id ". $rol[0]->getId() ." actualizado con éxito";
    }
}