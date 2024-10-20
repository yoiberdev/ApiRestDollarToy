<?php

namespace app\Controllers;

use app\Auth\JwtAuth;
use app\Business\Usuario\UsuarioAdd;
use app\Business\Usuario\UsuarioGet;
use app\Business\Usuario\UsuarioUpdate;
use app\Business\Usuario\UsuarioDelete;
use app\Data\RolRepository;
use app\Data\UsuarioRepository;
use app\Validators\UsuarioValidator;

class UsuarioController
{
    private UsuarioAdd $create;
    private UsuarioGet $get;
    private UsuarioUpdate $update;
    private UsuarioDelete $delete;
    private JwtAuth $jwtAuth;

    public function __construct(
        UsuarioAdd $create,
        UsuarioGet $get,
        UsuarioUpdate $update,
        UsuarioDelete $delete,
        JwtAuth $jwtAuth
    ) {
        $this->create = $create;
        $this->get = $get;
        $this->update = $update;
        $this->delete = $delete;
        $this->jwtAuth = $jwtAuth;
    }

    public function handleRequest(string $method, array $data): string
    {
        switch ($method) {
            case 'find':
                $usuarios = $this->get->find($data);
                $result = array_map(function ($usuario) {
                    return [
                        'id' => $usuario->getId(),
                        'nombre' => $usuario->getNombre(),
                        'apellido' => $usuario->getApellido(),
                        'email' => $usuario->getEmail(),
                        'celular' => $usuario->getCelular(),
                        'id_rol' => $usuario->getIdUsuarioRol()
                    ];
                }, $usuarios);
                return json_encode($result);

            case 'create':
                $result = $this->create->add($data);
                return json_encode(['message' => 'Usuario creado exitosamente', 'data' => $result]);

            case 'update':
                $result =$this->update->updateById($data['id'], $data);
                return json_encode(['message' => $result]);

            case 'delete':
                $this->delete->deleteById($data['id']);
                return json_encode(['message' => 'Usuario eliminado exitosamente']);

            default:
                return json_encode(['error' => 'Método no soportado']);
        }
    }

    public function login(array $data): string
    {
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return json_encode(['error' => 'Email o contraseña no proporcionados']);
        }

        $this->get->validateLogin($email, $password);
        $usuario = $this->get->find(['email' => $email]);

        $token = $this->jwtAuth->generateToken([
            'id' => $usuario[0]->getId(),
            'nombre' => $usuario[0]->getNombre(),
            'email' => $usuario[0]->getEmail(),
            'id_rol' => $usuario[0]->getIdUsuarioRol()
        ]);

        return json_encode(['token' => $token]);
    }

    public static function createInstance(): self
    {
        $repository = new UsuarioRepository();
        $rol = new RolRepository();
        $validator = new UsuarioValidator();
        $secretKey = getenv('JWT_SECRET_KEY');

        return new self(
            new UsuarioAdd($repository, $rol, $validator),
            new UsuarioGet($repository, $validator),
            new UsuarioUpdate($repository, $rol, $validator),
            new UsuarioDelete($repository),
            new JwtAuth($secretKey)
        );
    }
}