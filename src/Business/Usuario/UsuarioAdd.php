<?php

namespace app\Business\Usuario;

use app\exceptions\DataException;
use app\Interfaces\ValidatorInterface;
use app\Interfaces\UsuarioInterface;
use app\Exceptions\ValidationException;
use app\Interfaces\RolInterface;
use app\Models\Usuario;

class UsuarioAdd
{
    private UsuarioInterface $usuario;
    private RolInterface $rol;
    private ValidatorInterface $validator;

    public function __construct(UsuarioInterface $usuario, RolInterface $rol, ValidatorInterface $validator)
    {
        $this->usuario = $usuario;
        $this->rol = $rol;
        $this->validator = $validator;
    }

    public function add($data)
    {
        if (!$this->validator->validateAdd($data)) {
            throw new ValidationException($this->validator->getError());
        }

        if (!$this->rol->exists((int)$data['id_rol'])) {
            throw new DataException('Rol con id ' . $data['id_rol'] . ' no encontrado');
        }

        $usuario = new Usuario(
            0,
            $data['nombre'],
            $data['apellido'],
            $data['email'],
            $data['celular'],
            $data['password'],
            $data['id_rol']
        );

        return $this->usuario->save($usuario);
    }
}
