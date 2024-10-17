<?php

namespace app\Data;

use PDO;
use app\Interfaces\SedesInterface;
use app\Models\Sedes;

class SedeRepository extends BaseData implements SedesInterface
{
    public function find(array $filters): array
    {
        $sql = "SELECT * FROM tb_sedes";
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

        $sedes = [];
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $sede) {
            $sedes[] = new Sedes($sede->id_sede, $sede->nombre, $sede->direccion, $sede->ciudad);
        }

        return $sedes;
    }

    public function save(Sedes $sede): bool
    {
        return true;
    }

    public function deleteById(int $id): bool
    {
        $sql = "DELETE FROM tb_sedes WHERE id_sede = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM tb_sedes WHERE id_sede = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->count > 0;
    }
}