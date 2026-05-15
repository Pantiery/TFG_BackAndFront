<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class CarritoModel
{
    private $pdo;

    // Constructor para establecer conexión a la base de datos
    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    // Obtener carrito por usuario
    public function getByUserId($usuarioId)
    {
        $sql = 'SELECT * FROM carrito 
            WHERE usuario_id = ? 
            LIMIT 1';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$usuarioId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear carrito
    public function create($usuarioId)
    {
        $sql = 'INSERT INTO carrito (usuario_id) VALUES (?)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$usuarioId]);

        return $this->pdo->lastInsertId();
    }
    // Obtener estado de prenda
    public function getEstadoPrenda($prendaId)
    {
        $sql = 'SELECT estado_publicacion 
            FROM prendas 
            WHERE id = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$prendaId]);

        return $stmt->fetchColumn();
    }

    // Comprobar si prenda ya está en carrito
    public function itemExiste($carritoId, $prendaId)
    {
        $sql = 'SELECT COUNT(*) 
            FROM item_carrito 
            WHERE carrito_id = ? 
            AND prenda_id = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $carritoId,
            $prendaId
        ]);

        return $stmt->fetchColumn() > 0;
    }

    // Añadir prenda al carrito
    public function addItem($carritoId, $prendaId)
    {
        $sql = 'INSERT INTO item_carrito (
                carrito_id,
                prenda_id
            )
            VALUES (?, ?)';

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $carritoId,
            $prendaId
        ]);
    }

    // Obtener productos del carrito
    public function getItems($carritoId)
    {
        $sql = 'SELECT 
                p.*,
                tp.nombre AS tipo,
                c.nombre AS colegio_nombre,
                ec.nombre AS estado_calidad
            FROM item_carrito ic
            JOIN prendas p ON ic.prenda_id = p.id
            LEFT JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
            LEFT JOIN colegios c ON p.colegio_id = c.id
            LEFT JOIN estados_calidad ec ON p.estado_calidad_id = ec.id
            WHERE ic.carrito_id = ?';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$carritoId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar prenda del carrito
    public function removeItem($carritoId, $prendaId)
    {
        $sql = 'DELETE FROM item_carrito
            WHERE carrito_id = ? 
            AND prenda_id = ?';

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $carritoId,
            $prendaId
        ]);
    }

    public function vaciarCarrito($carritoId)
    {
        $sql = 'DELETE FROM item_carrito 
            WHERE carrito_id = ?';

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$carritoId]);
    }
}
