<?php

namespace App\Services;

use App\Core\Database;

class VentaService
{
    // Crear venta y devolver ID

    public function crearVenta($usuarioId)
    {
        $pdo = Database::getConnection();

        $sql = "INSERT INTO ventas (comprador_id, estado_pago, total)
                VALUES (?, 'pendiente', 0)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([ $usuarioId ]);

        return $pdo->lastInsertId();
    }

    // Insertar detalles de venta

    public function insertarDetalle($ventaId, $items)
    {
        $pdo = Database::getConnection();

        $sql = 'INSERT INTO detalle_venta 
            (venta_id, prenda_id, precio_unitario, comision, importe_vendedor)
            VALUES (?, ?, ?, ?, ?)';

        $stmt = $pdo->prepare($sql);

        foreach ($items as $item) {
            // 🔥 comprobar si la prenda ya está vendida
            $sqlCheck = 'SELECT COUNT(*) FROM detalle_venta WHERE prenda_id = ?';
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([ $item[ 'id' ] ]);

            if ($stmtCheck->fetchColumn() > 0) {
                throw new \Exception('Una de las prendas ya ha sido vendida');
            }

            $precio = $item[ 'precio_asignado' ];
            $comision = $precio * 0.1;
            $importe = $precio - $comision;

            $stmt->execute([
                $ventaId,
                $item[ 'id' ],
                $precio,
                $comision,
                $importe,
            ]);

            // Actualizar estado de prenda a 'vendida'
            $sqlUpdate = "UPDATE prendas SET estado_publicacion = 'vendida' WHERE id = ?";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([ $item[ 'id' ] ]);
        }
    }

    // Actualizar total de venta

    public function actualizarTotal($ventaId, $items)
    {
        $pdo = Database::getConnection();

        $total = 0;

        foreach ($items as $item) {
            $total += $item[ 'precio_asignado' ];
        }

        $sql = 'UPDATE ventas SET total = ? WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([ $total, $ventaId ]);
    }

    // Obtener compras por usuario
    public function obtenerComprasPorUsuario($usuarioId)
    {
        $pdo = Database::getConnection();

        $sql = 'SELECT 
                v.id AS venta_id,
                v.fecha,
                v.total,
                p.id AS prenda_id,
                p.imagen,
                tp.nombre AS tipo,
                c.nombre AS colegio,
                dv.precio_unitario
            FROM ventas v
            JOIN detalle_venta dv ON v.id = dv.venta_id
            JOIN prendas p ON dv.prenda_id = p.id
            LEFT JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
            LEFT JOIN colegios c ON p.colegio_id = c.id
            WHERE v.comprador_id = ?
            ORDER BY v.fecha DESC';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([ $usuarioId ]);

        return $stmt->fetchAll();
    }
}
