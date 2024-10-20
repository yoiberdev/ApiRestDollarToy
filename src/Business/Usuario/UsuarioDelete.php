<?php

namespace app\Business\Usuario;

use app\exceptions\DataException;
use app\Interfaces\UsuarioInterface;

class UsuarioDelete
{
    private UsuarioInterface $usuario;

    public function __construct(UsuarioInterface $usuario)
    {
        $this->usuario = $usuario;
    }

    public function deleteById(int $id = null): bool
    {
        if (!$id) {
            throw new DataException('Debe proporcionar el ID del usuario a eliminar');
        }

        if (!$this->usuario->exists($id)) {
            throw new DataException('Usuario con id '.$id.' no encontrado');
        }

        return $this->usuario->delete($id);
    }
}