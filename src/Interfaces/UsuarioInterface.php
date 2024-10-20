<?php

namespace app\Interfaces;

use app\Models\Usuario;

interface UsuarioInterface
{
    public function find(array $filters): array;
    public function save(Usuario $producto): bool;
    public function delete(int $id): bool;
    public function exists(int $id): bool;
}