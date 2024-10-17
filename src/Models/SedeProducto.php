<?php

namespace app\Models;

class SedeProducto
{
    private int $id_sede;
    private int $id_producto;
    private int $stock_disponible;

    public function __construct(int $id_sede, int $id_producto, int $stock_disponible)
    {
        $this->id_sede = $id_sede;
        $this->id_producto = $id_producto;
        $this->stock_disponible = $stock_disponible;
    }

    public function getId_sede()
    {
        return $this->id_sede;
    }

    public function getId_producto()
    {
        return $this->id_producto;
    }

    public function getStock_disponible()
    {
        return $this->stock_disponible;
    }

    public function setId_sede($id_sede)
    {
        $this->id_sede = $id_sede;
    }

    public function setId_producto($id_producto)
    {
        $this->id_producto = $id_producto;
    }

    public function setStock_disponible($stock_disponible)
    {
        $this->stock_disponible = $stock_disponible;
    }
}
