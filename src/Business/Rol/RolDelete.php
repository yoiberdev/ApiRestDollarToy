<?php

namespace app\Business\Rol;

use app\exceptions\DataException;
use app\Interfaces\RolInterface;

class RolDelete
{
    private RolInterface $rol;

    public function __construct(RolInterface $rol)
    {
        $this->rol = $rol;
    }

    public function deleteById(int $id = null): bool
    {
        if (!$id) {
            throw new DataException('Debe proporcionar el ID del rol a eliminar');
        }

        if (!$rol = $this->rol->exists($id)) {
            throw new DataException('Rol con id '.$id.' no encontrado');
        }

        return $this->rol->deleteById($id);
    }
}