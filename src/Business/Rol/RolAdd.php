<?php

namespace app\Business\Rol;

use app\Interfaces\ValidatorInterface;
use app\Interfaces\RolInterface;
use app\Models\Rol;
use app\Exceptions\ValidationException;

class RolAdd
{
    private RolInterface $rol;
    private ValidatorInterface $validator;

    public function __construct(RolInterface $rol, ValidatorInterface $validator)
    {
        $this->rol = $rol;
        $this->validator = $validator;
    }

    public function add($data)
    {
        if (!$this->validator->validateAdd($data)) {
            throw new ValidationException($this->validator->getError());
        }

        $rol = new Rol(0, $data['nombre']);

        return $this->rol->save($rol);
    }
}