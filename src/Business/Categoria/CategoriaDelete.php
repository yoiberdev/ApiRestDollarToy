<?php

namespace app\Business\Categoria;

use app\exceptions\DataException;
use app\Interfaces\CategoriaInterface;

class CategoriaDelete
{
    private CategoriaInterface $categoria;

    public function __construct(CategoriaInterface $categoria)
    {
        $this->categoria = $categoria;
    }

    public function deleteById(int $id = null): bool
    {
        if (!$id) {
            throw new DataException('Debe proporcionar el ID del rol a eliminar');
        }

        if (!$this->categoria->exists($id)) {
            throw new DataException('Categoria con id '.$id.' no encontrado');
        }

        return $this->categoria->deleteById($id);
    }
}