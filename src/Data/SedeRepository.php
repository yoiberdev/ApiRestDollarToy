<?php

namespace app\Data;

use PDO;
use app\Interfaces\SedeInterface;
use app\Models\Sede;

class SedeRepository extends BaseData implements SedeInterface
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

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function save(Sede $sede): bool
    {
        $query = "CALL sp_guardar_sede(?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);

        $id = $sede->getId();
        $nombre = $sede->getNombre();
        $direccion = $sede->getDireccion();
        $ciudad = $sede->getCiudad();

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(3, $direccion, PDO::PARAM_STR);
        $stmt->bindParam(4, $ciudad, PDO::PARAM_STR);

        return $stmt->execute();
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