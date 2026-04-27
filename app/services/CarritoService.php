<?php

namespace App\Services;

use App\Core\Database;
use PDO;

class CarritoService
 {
    private $db;

    public function __construct()
 {
        $this->db = Database::getConnection();
    }

    // Obtener carrito por usuario

    public function getByUserId( $usuarioId )
 {
        $sql = 'SELECT * FROM carrito WHERE usuario_id = ? LIMIT 1';
        $stmt = $this->db->prepare( $sql );
        $stmt->execute( [ $usuarioId ] );

        return $stmt->fetch( PDO::FETCH_ASSOC );
    }

    // Crear carrito

    public function create( $usuarioId )
 {
        $sql = 'INSERT INTO carrito (usuario_id) VALUES (?)';
        $stmt = $this->db->prepare( $sql );
        $stmt->execute( [ $usuarioId ] );

        return [
            'id' => $this->db->lastInsertId()
        ];
    }

    // Añadir prenda al carrito

    public function addItem( $carritoId, $prendaId )
 {
        // comprobar si la prenda ya está vendida
        $sqlEstado = 'SELECT estado_publicacion FROM prendas WHERE id = ?';
        $stmtEstado = $this->db->prepare( $sqlEstado );
        $stmtEstado->execute( [ $prendaId ] );

        $estado = $stmtEstado->fetchColumn();

        if ( $estado === 'vendida' ) {
            return false;
            // no permitir añadir
        }
        // comprobar si ya existe
        $sql = "SELECT COUNT(*) FROM item_carrito 
            WHERE carrito_id = ? AND prenda_id = ?";
        $stmt = $this->db->prepare( $sql );
        $stmt->execute( [ $carritoId, $prendaId ] );

        $existe = $stmt->fetchColumn();

        if ( $existe > 0 ) {
            return false;
            // ya está en carrito
        }

        // insertar si no existe
        $sql = "INSERT INTO item_carrito (carrito_id, prenda_id)
            VALUES (?, ?)";
        $stmt = $this->db->prepare( $sql );

        return $stmt->execute( [ $carritoId, $prendaId ] );
    }

    // Obtener productos del carrito

    public function getItems( $carritoId )
 {
        $sql = "SELECT 
            p.*,
            tp.nombre AS tipo,
            c.nombre AS colegio_nombre
        FROM item_carrito ic
        JOIN prendas p ON ic.prenda_id = p.id
        LEFT JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
        LEFT JOIN colegios c ON p.colegio_id = c.id
        WHERE ic.carrito_id = ?";

        $stmt = $this->db->prepare( $sql );
        $stmt->execute( [ $carritoId ] );

        return $stmt->fetchAll( PDO::FETCH_ASSOC );
    }

    // Obtener items del carrito por usuario

    public function getItemsByUser( $usuarioId )
 {
        // 1. Obtener carrito del usuario
        $carrito = $this->getByUserId( $usuarioId );

        // 2. Si no tiene carrito → devolver vacío
        if ( !$carrito ) {
            return [];
        }

        // 3. Obtener items del carrito
        return $this->getItems( $carrito[ 'id' ] );
    }

    // Eliminar item del carrito

    public function removeItem( $carritoId, $prendaId )
 {
        $sql = "DELETE FROM item_carrito
                WHERE carrito_id = ? AND prenda_id = ?";

        $stmt = $this->db->prepare( $sql );
        $stmt->execute( [ $carritoId, $prendaId ] );
    }

    // Vaciar carrito

    public function vaciarCarrito( $carritoId )
 {
        $sql = 'DELETE FROM item_carrito WHERE carrito_id = ?';
        $stmt = $this->db->prepare( $sql );
        $stmt->execute( [ $carritoId ] );
    }
}