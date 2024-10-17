<?php

namespace app\Interfaces;

use app\Models\Categoria;

interface CategoriaInterface
{
    public function find(array $filters): array;
    public function create(Categoria $rol): bool;
    public function update(Categoria $rol): void;
    public function deleteById(int $id): bool;
    public function exists(int $id): bool;
}