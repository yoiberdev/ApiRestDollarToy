<?php

namespace app\Business\Sede;

use app\exceptions\DataException;
use app\Interfaces\SedeInterface;
use app\Validators\SedeValidator;

class SedeGet
{
    private SedeInterface $sede;
    private SedeValidator $validator;

    public function __construct(SedeInterface $sede, SedeValidator $validator)
    {
        $this->sede = $sede;
        $this->validator = $validator;
    }

    public function find(array $filters): array
    {
        if (!$this->validator->validateFind($filters)) {
            throw new DataException($this->validator->getError());
        }

        $sedes = $this->sede->find($filters);

        if (empty($sedes)) {
            if (isset($filters['id_sede'])) {
                throw new DataException('Sede con id ' . $filters['id_sede'] . ' no encontrado');
            }
            if (isset($filters['nombre'])) {
                throw new DataException('No se encontró ningún sede con el nombre "' . $filters['nombre'] . '"');
            }
            if (isset($filters['direccion'])) {
                throw new DataException('No se encontró ningún sede con la dirección "' . $filters['direccion'] . '"');
            }
            if (isset($filters['ciudad'])) {
                throw new DataException('No se encontró ningún sede con la ciudad "' . $filters['ciudad'] . '"');
            }
            throw new DataException('No hay sedes disponibles que coincidan con los criterios');
        }

        return $sedes;
    }
}