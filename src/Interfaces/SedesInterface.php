<?php

namespace app\Interfaces;

use app\Models\Sedes;

interface SedesInterface
{
    public function find(array $filters): array;
    public function save(Sedes $sede): bool;
    public function deleteById(int $id): bool;
    public function exists(int $id): bool;
}