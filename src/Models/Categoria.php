<?php

namespace app\Models;

class Categoria
{
    public function __construct(
        private int $id,
        private string $nombre,
        private string $descripcion,
    ) {}

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
}