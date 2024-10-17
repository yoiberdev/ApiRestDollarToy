<?php

namespace app\Data;

use PDO;
use app\Interfaces\CategoriaInterface;
use app\Models\Categoria;

class CategoriaRepository extends BaseData implements CategoriaInterface
{
    const TABLE = 'tb_categoria';

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

        $categories = [];
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $rol) {
            $categories[] = new Categoria($rol->id_categoria, $rol->nombre, $rol->descripcion);
        }

        return $categories;
    }
    public function create(Categoria $categoria): bool
    {
        $sql = "INSERT INTO " . self::TABLE . " (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->pdo->prepare($sql);

        $nombre = $categoria->getNombre();
        $descripcion = $categoria->getDescripcion();
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }
    public function update(Categoria $rol): void
    {
        $sql = "UPDATE " . self::TABLE . " SET nombre = :nombre, descripcion = :descripcion WHERE id_categoria = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $rol->getNombre(), PDO::PARAM_STR);
        $stmt->bindParam(':description', $rol->getDescripcion(), PDO::PARAM_STR);
        $stmt->execute();
    }
    public function deleteById(int $id): bool
    {
        $sql = "DELETE FROM ". self::TABLE ." WHERE id_rol = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM " . self::TABLE . " WHERE id_categoria = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->count > 0;
    }
}