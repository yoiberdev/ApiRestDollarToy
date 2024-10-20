<?php

namespace app\Business\Rol;

use app\Interfaces\ValidatorInterface;
use app\Interfaces\RolInterface;
use app\Exceptions\ValidationException;
use app\exceptions\DataException;
use app\Models\Rol;

class RolUpdate
{
    private RolInterface $rol;
    private ValidatorInterface $validator;

    public function __construct(RolInterface $rol, ValidatorInterface $validator)
    {
        $this->rol = $rol;
        $this->validator = $validator;
    }

    public function update($id, $data)
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

        $rol = new Rol($id, $data['nombre']);

        return $this->rol->save($rol);
    }
}