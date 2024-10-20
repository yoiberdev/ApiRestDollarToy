<?php

namespace app\Data;

use PDO;
use app\Interfaces\UsuarioInterface;
use app\Models\Usuario;
class UsuarioRepository extends BaseData implements UsuarioInterface
{
    const TABLE = "tb_usuario";

    public function find(array $filters): array
    {
        $sql = "CALL sp_listar_usuario(?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        $id = $filters['id'] ?? null;
        $nombre = $filters['nombre'] ?? null;
        $apellido = $filters['apellido'] ?? null;
        $email = $filters['email'] ?? null;
        $id_rol = $filters['id_rol'] ?? null;

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(3, $apellido, PDO::PARAM_STR);
        $stmt->bindParam(4, $email, PDO::PARAM_STR);
        $stmt->bindParam(5, $id_rol, PDO::PARAM_INT);

        $stmt->execute();

        $usuarios = [];
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $usuario) {
            $usuarios[] = new Usuario($usuario->id_usuario, $usuario->nombre, $usuario->apellido, $usuario->email, $usuario->celular, $usuario->password, $usuario->id_usuario_rol);
        }

        return $usuarios;
    }
    public function save(Usuario $producto): bool
    {
        $query = "CALL sp_guardar_usuario(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);

        $id = $producto->getId();
        $nombre = $producto->getNombre();
        $apellido = $producto->getApellido();
        $email = $producto->getEmail();
        $celular = $producto->getCelular();
        $password = $producto->getpassword();
        $id_usuario_rol = $producto->getIdUsuarioRol();

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(3, $apellido, PDO::PARAM_STR);
        $stmt->bindParam(4, $email, PDO::PARAM_STR);
        $stmt->bindParam(5, $celular, PDO::PARAM_INT);
        $stmt->bindParam(6, $password, PDO::PARAM_STR);
        $stmt->bindParam(7, $id_usuario_rol, PDO::PARAM_INT);

        return $stmt->execute();
    }
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM " . self::TABLE . " WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->count > 0;
    }
}