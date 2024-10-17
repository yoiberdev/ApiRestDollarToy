<?php

namespace app\Models;

class Sedes
{
    private int $id;
    private string $nombre;
    private string $direccion;
    private string $ciudad;

    public function __construct(int $id, string $nombre, string $direccion, string $ciudad)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->ciudad = $ciudad;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getCiudad()
    {
        return $this->ciudad;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }
}