<?php

namespace app\Data;

use PDO;
use app\Interfaces\RolInterface;
use app\Models\Rol;

class RolRepository extends BaseData implements RolInterface
{
    const TABLE = 'tb_rol';

    public function find(array $filters): array
    {
        $sql = "CALL sp_listar_rol(?, ?)";
        $stmt = $this->pdo->prepare($sql);

        $id = $filters['id_rol'] ?? null;
        $nombre = $filters['nombre'] ?? null;

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nombre, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(Rol $rol): bool
    {
        $query = "CALL sp_guardar_rol(?, ?)";
        $stmt = $this->pdo->prepare($query);
        
        $id = $rol->getId();
        $nombre = $rol->getNombre();
        
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function deleteById(int $id): bool
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM " . self::TABLE . " WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->count > 0;
    }
}
