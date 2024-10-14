<?php

namespace app\Data;

use PDO;
use app\Interfaces\RolInterface;
use app\Models\Rol;

class RolRepository extends BaseData implements RolInterface
{
    public function getAll(): array
    {
        $sql = "SELECT * FROM tb_rol";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rols = [];
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $rol) {
            $rols[] = new Rol($rol->id_rol, $rol->nombre);
        }
        return $rols;
    }

    public function getById(int $id): ?Rol
    {
        $sql = "SELECT * FROM tb_rol WHERE id_rol = :id";   
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row ? new Rol($row->id_rol, $row->nombre) : null;
    }

    public function create(Rol $rol): bool
    {
        $sql = "INSERT INTO tb_rol (nombre) VALUES (:nombre)";
        $stmt = $this->pdo->prepare($sql);

        $nombre = $rol->getNombre();
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update(Rol $rol): void
    {
        $sql = "UPDATE tb_rol SET nombre = :nombre WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $rol->getNombre(), PDO::PARAM_STR);
        $stmt->bindParam(':id', $rol->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteById(int $id): bool
    {
        $sql = "DELETE FROM tb_rol WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) FROM tb_rol WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->count > 0;
    }
}