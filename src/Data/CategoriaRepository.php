<?php

namespace app\Data;

use PDO;
use app\Data\BaseData;
use app\Interfaces\CategoriaInterface;
use app\Models\Categoria;


class CategoriaRepository extends BaseData implements CategoriaInterface
{
    const TABLE = 'tb_categoria';

    public function find(array $filters): array
    {
        $query = "CALL sp_listar_categoria(?, ?)";
        $stmt = $this->pdo->prepare($query);

        $id = $filters['id_categoria'] ?? null;
        $nombre = $filters['nombre'] ?? null;

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nombre, PDO::PARAM_STR);

        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(Categoria $categoria): bool
    {
        $query = "CALL sp_guardar_categoria(?, ?, ?)";
        $stmt = $this->pdo->prepare($query);

        $id = $categoria->getId();
        $nombre = $categoria->getNombre();
        $descripcion = $categoria->getDescripcion();
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(3, $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE id_categoria = :id_categoria";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_categoria', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM " . self::TABLE . " WHERE id_categoria = :id_categoria";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_categoria', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->count > 0;
    }
}