<?php

namespace app\Interfaces;

use app\Models\Sede;

interface SedeInterface
{
    public function find(array $filters): array;
    public function save(Sede $sede): bool;
    public function deleteById(int $id): bool;
    public function exists(int $id): bool;
}