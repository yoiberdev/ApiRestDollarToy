<?php

namespace app\Interfaces;

use app\Models\Rol;

interface RolInterface
{
    public function find(array $filters): array;
    public function save(Rol $rol): bool;
    public function deleteById(int $id): bool;
    public function exists(int $id): bool;
}