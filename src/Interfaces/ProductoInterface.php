<?php

namespace app\Interfaces;

use app\Models\Producto;
use app\Models\SedeProducto;

interface ProductoInterface
{
    public function find(array $filters): array;
    public function save(Producto $producto, SedeProducto $sedeProducto): bool;
    public function delete(int $id): bool;
    public function exists(int $id): bool;
}