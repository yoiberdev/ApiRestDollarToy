<?php

namespace app\Business\Sede;

use app\Interfaces\ValidatorInterface;
use app\Interfaces\SedeInterface;
use app\Models\Sede;
use app\Exceptions\ValidationException;

class SedeAdd
{
    private SedeInterface $sede;
    private ValidatorInterface $validator;

    public function __construct(SedeInterface $sede, ValidatorInterface $validator)
    {
        $this->sede = $sede;
        $this->validator = $validator;
    }

    public function add($data)
    {
        if (!$this->validator->validateAdd($data)) {
            throw new ValidationException($this->validator->getError());
        }

        $sede = new Sede(0, $data['nombre'], $data['direccion'], $data['ciudad']);
        $this->sede->save($sede);
    }
}