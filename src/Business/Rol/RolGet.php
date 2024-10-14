<?php

namespace app\Business\Rol;

use app\exceptions\DataException;
use app\Interfaces\RolInterface;

class RolGet
{
    private RolInterface $rol;

    public function __construct(RolInterface $rol)
    {
        $this->rol = $rol;
    }

    public function getAll(): array
    {
        $roles = $this->rol->getAll();

        if (empty($roles)) {
            throw new DataException('No hay roles disponibles');
        }

        return $roles;
    }

    public function getById(int $id): ?array
    {
        if (!$rol = $this->rol->exists($id)) {
            throw new DataException('Rol con id '.$id.' no encontrado');
        }
        
        return $this->rol->getById($id);
    }
}