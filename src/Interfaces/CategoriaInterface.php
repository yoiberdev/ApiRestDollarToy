<?php

namespace app\Interfaces;

use app\Models\Categoria;

interface CategoriaInterface
{
    public function find(array $filters): array;
    public function save(Categoria $rol): bool;
    public function delete(int $id): bool;
    public function exists(int $id): bool;
}