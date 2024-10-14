<?php

namespace app\Interfaces;

use app\Models\Rol;

interface RolInterface
{
    public function getAll(): array;
    public function getById(int $id): ?Rol;
    public function create(Rol $rol): bool;
    public function update(Rol $rol): void;
    public function deleteById(int $id): bool;
    public function exists(int $id): bool;
}