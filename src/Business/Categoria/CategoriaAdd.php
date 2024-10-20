<?php

namespace app\Business\Categoria;

use app\Interfaces\ValidatorInterface;
use app\Interfaces\CategoriaInterface;
use app\Exceptions\ValidationException;
use app\Models\Categoria;

class CategoriaAdd
{
    private CategoriaInterface $categoria;
    private ValidatorInterface $validator;

    public function __construct(CategoriaInterface $categoria, ValidatorInterface $validator)
    {
        $this->categoria = $categoria;
        $this->validator = $validator;
    }

    public function add($data)
    {
        if (!$this->validator->validateAdd($data)) {
            throw new ValidationException($this->validator->getError());
        }

        $categoria = new Categoria(0, $data['nombre'], $data['descripcion']);

        $this->categoria->save($categoria);
    }
}