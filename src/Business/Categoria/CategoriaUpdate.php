<?php

namespace app\Business\Categoria;

use app\Interfaces\ValidatorInterface;
use app\Interfaces\CategoriaInterface;
use app\Exceptions\ValidationException;
use app\exceptions\DataException;

class CategoriaUpdate
{
    private CategoriaInterface $categoria;
    private ValidatorInterface $validator;

    public function __construct(CategoriaInterface $categoria, ValidatorInterface $validator)
    {
        $this->categoria = $categoria;
        $this->validator = $validator;
    }

    public function updateById(int $id = null, array $data = []): string
    {
        if (!$this->validator->validateId($id)) {
            throw new ValidationException($this->validator->getError());
        }

        if (!$this->validator->validateUpdate($data)) {
            throw new ValidationException($this->validator->getError());
        }

        if (!$this->categoria->exists((int)$data['id'])) {
            throw new DataException('Categoria con id '.$id.' no encontrado');
        }

        $categoria = $this->categoria->find(['id_categoria' => $id]);

        $this->categoria->update($categoria[0]);

        return "Categoria con id ". $categoria[0]->getId() ." actualizado con éxito";
    }
}