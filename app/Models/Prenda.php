<?php

namespace App\Models;

class Prenda
{
    // funcion para crear una prenda nueva en la base de datos
    public function crear($pdo, $data)
    {
        $stmt = $pdo->prepare("
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
            'imagen' => $data['imagen']
        ]);
    }

    // funcion para obtener todas las prendas publicadas
    public function obtenerPublicadas($pdo)
    {
        $stmt = $pdo->query("
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
    ");

        return $stmt->fetchAll();
    }

    // funcion para obtener prendas por usuario y estado de publicación
    public function obtenerPorUsuarioYEstado($pdo, $usuarioId, $estado)
    {
        $stmt = $pdo->prepare("
        SELECT p.*, tp.nombre AS tipo, c.nombre AS colegio
        FROM prendas p
        JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
        JOIN colegios c ON p.colegio_id = c.id
        WHERE p.usuario_id = :usuario_id
        AND p.estado_publicacion = :estado
    ");

        $stmt->execute([
            'usuario_id' => $usuarioId,
            'estado' => $estado
        ]);

        return $stmt->fetchAll();
    }
}