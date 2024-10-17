<?php

namespace app\Data;

use app\Interfaces\ProductoInterface;
use PDO;
use app\Interfaces\RolInterface;
use app\Models\Producto;
use app\Models\Categoria;
use app\Models\SedeProducto;

class ProductoRepository extends BaseData implements ProductoInterface
{
    const TABLE = 'tb_producto';

    public function find(array $filters): array
    {
        $sql = "CALL sp_listar_producto(?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        $id = $filters['id'] ?? null;
        $nombre = $filters['nombre'] ?? null;
        $id_categoria_producto = $filters['id_categoria_producto'] ?? null;
        $id_sede = $filters['id_sede'] ?? null;
        $precio_min = $filters['precio_min'] ?? null;
        $precio_max = $filters['precio_max'] ?? null;

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(3, $id_categoria_producto, PDO::PARAM_INT);
        $stmt->bindParam(4, $id_sede, PDO::PARAM_INT);
        $stmt->bindParam(5, $precio_min, PDO::PARAM_STR);
        $stmt->bindParam(6, $precio_max, PDO::PARAM_STR);

        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
       
    public function save(Producto $producto, SedeProducto $sedeProducto): bool
    {
        $query = "CALL sp_guardar_producto(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);

        $id = $producto->getId();
        $nombre = $producto->getNombre();
        $descripcion = $producto->getDescripcion();
        $precio = $producto->getPrecio();
        $imagen_url = $producto->getImg();
        $id_categoria_producto = $producto->getCategoria();
        $id_sede = $sedeProducto->getId_sede();
        $stock_disponible = $sedeProducto->getStock_disponible();

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(3, $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(4, $precio, PDO::PARAM_STR);
        $stmt->bindParam(5, $imagen_url, PDO::PARAM_STR);
        $stmt->bindParam(6, $id_categoria_producto, PDO::PARAM_INT);
        $stmt->bindParam(7, $id_sede, PDO::PARAM_INT);
        $stmt->bindParam(8, $stock_disponible, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE id_producto = :id_producto";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_producto', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM " . self::TABLE . " WHERE id_producto = :id_producto";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_producto', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->count > 0;
    }
}
