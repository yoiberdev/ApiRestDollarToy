<?php

namespace app\Models;

class Usuario
{
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $celular;
    private $password;
    private $id_usuario_rol;

    public function __construct($id, $nombre, $apellido, $email, $celular, $password, $id_usuario_rol)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->celular = $celular;
        $this->password = $password;
        $this->id_usuario_rol = $id_usuario_rol;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function getpassword()
    {
        return $this->password;
    }

    public function getIdUsuarioRol()
    {
        return $this->id_usuario_rol;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setIdUsuarioRol($id_usuario_rol)
    {
        $this->id_usuario_rol = $id_usuario_rol;
    }
}