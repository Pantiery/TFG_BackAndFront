<?php

namespace App\Services;

use App\Core\Database;

class VentaService
{
    // VENTAS

    // Crear venta y devolver ID

    public function crearVenta($usuarioId)
    {
        $pdo = Database::getConnection();

        $sql = "INSERT INTO ventas (comprador_id, estado_pago, total)
                VALUES (?, 'pendiente', 0)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuarioId]);

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
            $stmtCheck->execute([$item['id']]);

            if ($stmtCheck->fetchColumn() > 0) {
                throw new \Exception('Una de las prendas ya ha sido vendida');
            }

            $precio = $item['precio_asignado'];
            $comision = $precio * 0.1;
            $importe = $precio - $comision;

            $stmt->execute([
                $ventaId,
                $item['id'],
                $precio,
                $comision,
                $importe,
            ]);

            // Actualizar estado de prenda a 'vendida'
            $sqlUpdate = "UPDATE prendas SET estado_publicacion = 'vendida' WHERE id = ?";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([$item['id']]);
        }
    }

    // Actualizar total de venta

    public function actualizarTotal($ventaId, $items)
    {
        $pdo = Database::getConnection();

        $total = 0;

        foreach ($items as $item) {
            $total += $item['precio_asignado'];
        }

        $sql = 'UPDATE ventas SET total = ? WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$total, $ventaId]);
    }

    // COMPRAS

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
        $stmt->execute([$usuarioId]);

        return $stmt->fetchAll();
    }

    // VENTAS DEL VENDEDOR

    // Obtener ventas pendientes por usuario

    public function obtenerVentasPendientes($usuarioId)
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
        SELECT 
            dv.*, 
            p.usuario_id,
            p.imagen,
            tp.nombre AS tipo,
            c.nombre AS colegio
        FROM detalle_venta dv
        JOIN prendas p ON dv.prenda_id = p.id
        JOIN ventas v ON dv.venta_id = v.id
        JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
        JOIN colegios c ON p.colegio_id = c.id
        WHERE p.usuario_id = ?
        AND v.estado_pago = 'pendiente'
    ");

        $stmt->execute([$usuarioId]);

        return $stmt->fetchAll();
    }

    // Calcular total pendiente para el vendedor
    public function calcularTotalPendiente($ventas)
    {
        $total = 0;

        foreach ($ventas as $v) {
            $total += $v['importe_vendedor'];
        }

        return $total;
    }

    // Obtener ventas por usuario (historial)
    public function obtenerVentasPorUsuario($usuarioId)
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT 
                v.id AS venta_id,
                v.fecha,
                v.estado_pago,

                dv.precio_unitario,
                dv.comision,
                dv.importe_vendedor,

                p.imagen,

                tp.nombre AS tipo,
                c.nombre AS colegio

            FROM detalle_venta dv

            JOIN ventas v 
                ON dv.venta_id = v.id

            JOIN prendas p 
                ON dv.prenda_id = p.id

            JOIN tipos_prenda tp 
                ON p.tipo_prenda_id = tp.id

            JOIN colegios c 
                ON p.colegio_id = c.id

            WHERE p.usuario_id = ?

            ORDER BY v.fecha DESC
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$usuarioId]);

        return $stmt->fetchAll();
    }

    // ADMIN

    // Obtener todas las ventas agrupadas (admin)
    public function obtenerTodasLasVentas(
        $estado = null,
        $desde = null,
        $hasta = null,
        $vendedor = null
    ) {
        $pdo = Database::getConnection();

        $sql = "
        SELECT 
            v.id AS venta_id,
            v.fecha,
            v.estado_pago,
            v.total,

            dv.precio_unitario,
            dv.comision,
            dv.importe_vendedor,

            comprador.nombre AS comprador_nombre,
            vendedor.nombre AS vendedor_nombre,

            tp.nombre AS tipo_prenda,
            c.nombre AS colegio

        FROM ventas v

        JOIN detalle_venta dv 
            ON v.id = dv.venta_id

        JOIN prendas p 
            ON dv.prenda_id = p.id

        JOIN usuarios comprador 
            ON v.comprador_id = comprador.id

        JOIN usuarios vendedor 
            ON p.usuario_id = vendedor.id

        JOIN tipos_prenda tp 
            ON p.tipo_prenda_id = tp.id

        JOIN colegios c 
            ON p.colegio_id = c.id

        WHERE 1=1
    ";

        $params = [];

        if (!empty($estado)) {

            $sql .= " AND v.estado_pago = ?";
            $params[] = $estado;
        }

        if (!empty($desde)) {

            $sql .= " AND DATE(v.fecha) >= ?";
            $params[] = $desde;
        }

        if (!empty($hasta)) {

            $sql .= " AND DATE(v.fecha) <= ?";
            $params[] = $hasta;
        }

        if (!empty($vendedor)) {

            $sql .= " AND LOWER(vendedor.nombre) LIKE LOWER(?)";

            $params[] = "%{$vendedor}%";
        }

        $sql .= " ORDER BY v.fecha DESC";

        $stmt = $pdo->prepare($sql);

        $stmt->execute($params);

        $resultados = $stmt->fetchAll();

        // AGRUPAR POR VENTA

        $ventasAgrupadas = [];

        foreach ($resultados as $fila) {

            $ventaId = $fila['venta_id'];

            if (!isset($ventasAgrupadas[$ventaId])) {

                $ventasAgrupadas[$ventaId] = [
                    'venta_id' => $fila['venta_id'],
                    'fecha' => $fila['fecha'],
                    'estado_pago' => $fila['estado_pago'],
                    'comprador_nombre' => $fila['comprador_nombre'],
                    'total' => $fila['total'],
                    'prendas' => []
                ];
            }

            $ventasAgrupadas[$ventaId]['prendas'][] = [

                'tipo_prenda' => $fila['tipo_prenda'],
                'colegio' => $fila['colegio'],
                'vendedor_nombre' => $fila['vendedor_nombre'],
                'comision' => $fila['comision'],
                'importe_vendedor' => $fila['importe_vendedor']
            ];
        }

        return array_values($ventasAgrupadas);
    }

    // Obtener prendas de una venta
    public function obtenerPrendasDeVenta($ventaId)
    {
        $pdo = Database::getConnection();

        $sql = "
        SELECT
            tp.nombre AS tipo_prenda,
            c.nombre AS colegio,
            p.imagen,

            vendedor.nombre AS vendedor_nombre,

            dv.precio_unitario,
            dv.comision,
            dv.importe_vendedor

        FROM detalle_venta dv

        JOIN prendas p
            ON dv.prenda_id = p.id

        JOIN usuarios vendedor
            ON p.usuario_id = vendedor.id

        JOIN tipos_prenda tp
            ON p.tipo_prenda_id = tp.id

        JOIN colegios c
            ON p.colegio_id = c.id

        WHERE dv.venta_id = ?
    ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$ventaId]);

        return $stmt->fetchAll();
    }

    // Obtener venta por ID
    public function obtenerVentaPorId($ventaId)
    {
        $pdo = Database::getConnection();

        $sql = "
        SELECT 
            v.id,
            v.fecha,
            v.total,
            v.estado_pago,

            u.id AS comprador_id,
            u.nombre AS comprador_nombre,
            u.apellido1 AS comprador_apellido

        FROM ventas v

        JOIN usuarios u
            ON v.comprador_id = u.id

        WHERE v.id = ?
    ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$ventaId]);

        return $stmt->fetch();
    }

    // Obtener detalle completo de una venta
    public function obtenerDetalleVenta($ventaId)
    {
        // Obtener venta
        $venta = $this->obtenerVentaPorId($ventaId);

        // Si no existe
        if (!$venta) {
            return null;
        }

        // Obtener prendas
        $prendas = $this->obtenerPrendasDeVenta($ventaId);

        // Calcular totales
        $totalComisiones = 0;
        $totalVendedor = 0;

        foreach ($prendas as $prenda) {

            $totalComisiones += $prenda['comision'];
            $totalVendedor += $prenda['importe_vendedor'];
        }

        return [
            'venta' => $venta,
            'prendas' => $prendas,
            'total_comisiones' => $totalComisiones,
            'total_vendedor' => $totalVendedor
        ];
    }

    // Marcar venta como pagada
    public function marcarVentaPagada($ventaId)
    {
        $pdo = Database::getConnection();

        $sql = "UPDATE ventas SET estado_pago = 'pagado' WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ventaId]);
    }
}
