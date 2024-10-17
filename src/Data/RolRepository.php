<?php

namespace app\Data;

use PDO;
use app\Interfaces\RolInterface;
use app\Models\Rol;

class RolRepository extends BaseData implements RolInterface
{
    const TABLE = 'tb_rol';

    public function create(Rol $rol): bool
    {
        $sql = "INSERT INTO self::TABLE (nombre) VALUES (:nombre)";
        $stmt = $this->pdo->prepare($sql);

        $nombre = $rol->getNombre();
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update(Rol $rol): void
    {
        $sql = "UPDATE " . self::TABLE . " SET nombre = :nombre WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $rol->getNombre(), PDO::PARAM_STR);
        $stmt->bindParam(':id', $rol->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteById(int $id): bool
    {
        $sql = "DELETE FROM self::TABLE WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM self::TABLE WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->count > 0;
    }

    public function find(array $filters): array
    {
        $sql = "SELECT * FROM " . self::TABLE;
        $conditions = [];
        $params = [];

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if (!empty($value)) {
                    if ($key === 'search') {
                        $conditions[] = "nombre LIKE :search";
                        $params[":search"] = '%' . $value . '%';
                    } else {
                        $conditions[] = "$key = :$key";
                        $params[":$key"] = $value;
                    }
                }
            }

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $roles = [];
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $rol) {
            $roles[] = new Rol($rol->id_rol, $rol->nombre);
        }

        return $roles;
    }
}
