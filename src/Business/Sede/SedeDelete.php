<?php

namespace app\Business\Sede;

use app\exceptions\DataException;
use app\Interfaces\SedeInterface;

class SedeDelete
{
    private SedeInterface $sede;

    public function __construct(SedeInterface $sede)
    {
        $this->sede = $sede;
    }

    public function deleteById(int $id = null): bool
    {
        if (!$id) {
            throw new DataException('Debe proporcionar el ID del sede a eliminar');
        }

        if (!$this->sede->exists($id)) {
            throw new DataException('Sede con id '.$id.' no encontrado');
        }

        return $this->sede->deleteById($id);
    }
}