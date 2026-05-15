<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class PrendaModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    // funcion para crear una prenda nueva en la base de datos
    public function crear($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO prendas 
            (usuario_id, tipo_prenda_id, colegio_id, estado_calidad_id, precio_asignado, estado_publicacion, talla_id, genero_id, imagen) 
            VALUES (:usuario_id, :tipo_prenda_id, :colegio_id, :estado_calidad_id, :precio, 'pendiente', :talla_id, :genero_id, :imagen)
        ");

        return $stmt->execute([
            'usuario_id' => $data['usuario_id'],
            'tipo_prenda_id' => $data['tipo_prenda_id'],
            'colegio_id' => $data['colegio_id'],
            'estado_calidad_id' => $data['estado_calidad_id'],
            'precio' => $data['precio'],
            'talla_id' => $data['talla_id'],
            'genero_id' => $data['genero_id'],
            'imagen' => $data['imagen'],
        ]);
    }

    public function existeRelacionTipoColegio($colegio, $tipo)
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*) 
        FROM colegio_tipo_prenda 
        WHERE colegio_id = :colegio
        AND tipo_prenda_id = :tipo
    ");

        $stmt->execute([
            'colegio' => $colegio,
            'tipo' => $tipo,
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function obtenerPrecio($tipo, $estado)
    {
        $stmt = $this->pdo->prepare("
        SELECT precio 
        FROM precios_estandar 
        WHERE tipo_prenda_id = :tipo
        AND estado_calidad_id = :estado
    ");

        $stmt->execute([
            'tipo' => $tipo,
            'estado' => $estado,
        ]);

        return $stmt->fetchColumn();
    }

    // funcion para obtener todas las prendas publicadas
    public function obtenerPublicadas($usuarioId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.*, 
                tp.nombre AS tipo, 
                c.nombre AS colegio, 
                e.nombre AS estado,
                u.nombre AS vendedor
            FROM prendas p
            JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
            JOIN colegios c ON p.colegio_id = c.id
            JOIN estados_calidad e ON p.estado_calidad_id = e.id
            JOIN usuarios u ON p.usuario_id = u.id
            WHERE p.estado_publicacion = 'publicada'
            AND p.usuario_id != :usuario_id
        ");

        $stmt->execute([
            'usuario_id' => $usuarioId,
        ]);

        return $stmt->fetchAll();
    }

    // funcion para obtener prendas pendientes de revision
    public function obtenerPendientes()
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            p.*,
            tp.nombre AS tipo,
            c.nombre AS colegio,
            e.nombre AS estado,
            u.nombre AS vendedor,
            u.apellido1
        FROM prendas p
        JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
        JOIN colegios c ON p.colegio_id = c.id
        JOIN estados_calidad e ON p.estado_calidad_id = e.id
        JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.estado_publicacion = 'pendiente'
    ");

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // funcion para obtener una prenda por su id
    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            p.*,
            tp.nombre AS tipo,
            c.nombre AS colegio,
            e.nombre AS estado,
            u.nombre AS vendedor,
            u.apellido1,
            t.nombre AS talla,
            g.nombre AS genero
        FROM prendas p
        JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
        JOIN colegios c ON p.colegio_id = c.id
        JOIN estados_calidad e ON p.estado_calidad_id = e.id
        JOIN usuarios u ON p.usuario_id = u.id
        JOIN tallas t ON p.talla_id = t.id
        JOIN generos g ON p.genero_id = g.id
        WHERE p.id = :id
    ");

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // funcion para aprobar una prenda pendiente
    public function aprobar($id)
    {
        $stmt = $this->pdo->prepare("
        UPDATE prendas
        SET
        estado_publicacion = 'publicada',
        fecha_publicacion = NOW()
        WHERE id = :id
    ");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    // funcion para rechazar una prenda pendiente
    public function rechazar($id)
    {
        $stmt = $this->pdo->prepare("
        UPDATE prendas
        SET estado_publicacion = 'rechazada'
        WHERE id = :id
    ");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    // funcion para obtener prendas por usuario y estado de publicación
    public function obtenerPorUsuarioYEstado($usuarioId, $estado)
    {
        $stmt = $this->pdo->prepare('
            SELECT
                p.*,
                tp.nombre AS tipo,
                c.nombre AS colegio,
                dv.importe_vendedor,
                v.fecha AS fecha,
                v.estado_pago AS estado_pago
            FROM prendas p
            JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
            JOIN colegios c ON p.colegio_id = c.id
            LEFT JOIN detalle_venta dv ON dv.prenda_id = p.id
            LEFT JOIN ventas v ON dv.venta_id = v.id
            WHERE p.usuario_id = :usuario_id
            AND p.estado_publicacion = :estado
        ');

        $stmt->execute([
            'usuario_id' => $usuarioId,
            'estado' => $estado,
        ]);

        return $stmt->fetchAll();
    }
}
