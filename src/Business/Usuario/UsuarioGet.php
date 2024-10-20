<?php

namespace app\Business\Usuario;

use app\exceptions\DataException;
use app\exceptions\ValidationException;
use app\Interfaces\UsuarioInterface;
use app\Models\Usuario;
use app\Validators\UsuarioValidator;

class UsuarioGet
{
    private UsuarioInterface $usuario;
    private UsuarioValidator $validator;

    public function __construct(UsuarioInterface $usuario, UsuarioValidator $validator)
    {
        $this->usuario = $usuario;
        $this->validator = $validator;
    }

    public function find(array $filters): array
    {
        if (!$this->validator->validateFind($filters)) {
            throw new DataException($this->validator->getError());
        }
        
        $usuarios = $this->usuario->find($filters);

        if (empty($usuarios)) {
            if (isset($filters['id'])) {
                throw new DataException('Usuario con id ' . $filters['id'] . ' no encontrado');
            }
            if (isset($filters['nombre'])) {
                throw new DataException('No se encontró ningún usuario con el nombre "' . $filters['nombre'] . '"');
            }
            if (isset($filters['email'])) {
                throw new DataException('No se encontró ningún usuario con el email "' . $filters['email'] . '"');
            }
            throw new DataException('No hay usuarios disponibles que coincidan con los criterios');
        }

        return $usuarios;
    }

    public function validateLogin(string $email, string $password): bool
    {
        $usuario = $this->find(['email' => $email]);

        if (empty($usuario)) {
            throw new ValidationException('Usuario no encontrado');
        }

        if (!password_verify($password, $usuario[0]->getpassword())) {
            throw new ValidationException("Contraseña incorrecta, password es : " . $usuario[0]->getpassword() . " contraseña que se ha enviado: " . $password);
        }
        return true;
    }
}