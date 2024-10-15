<?php

namespace app\Business\Rol;

use app\exceptions\DataException;
use app\Interfaces\RolInterface;
use app\Models\Rol;
use app\Validators\RolValidator;

class RolGet
{
    private RolInterface $rol;
    private RolValidator $validator;

    public function __construct(RolInterface $rol, RolValidator $validator)
    {
        $this->rol = $rol;
        $this->validator = $validator;
    }

    public function find(array $filters): array
    {
        if (!$this->validator->validateFind($filters)) {
            throw new DataException($this->validator->getError());
        }

        $roles = $this->rol->find($filters);

        if (empty($roles)) {
            if (isset($filters['id_rol'])) {
                throw new DataException('Rol con id ' . $filters['id_rol'] . ' no encontrado');
            }
            if (isset($filters['nombre'])) {
                throw new DataException('No se encontró ningún rol con el nombre "' . $filters['nombre'] . '"');
            }
            throw new DataException('No hay roles disponibles que coincidan con los criterios');
        }

        return $roles;
    }
}
