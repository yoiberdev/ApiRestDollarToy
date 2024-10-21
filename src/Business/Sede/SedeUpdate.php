<?php

namespace app\Business\Sede;

use app\Interfaces\ValidatorInterface;
use app\Interfaces\SedeInterface;
use app\Exceptions\ValidationException;
use app\exceptions\DataException;
use app\Models\Sede;

class SedeUpdate
{
    private SedeInterface $sede;
    private ValidatorInterface $validator;

    public function __construct(SedeInterface $sede, ValidatorInterface $validator)
    {
        $this->sede = $sede;
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

        if (!$this->sede->exists((int)$data['id'])) {
            throw new DataException('Sede con id '.$id.' no encontrado');
        }

        $sede = new Sede($id, $data['nombre'], $data['direccion'], $data['ciudad']);

        return $this->sede->save($sede);
    }
}