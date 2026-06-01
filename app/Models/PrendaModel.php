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

    // FUNCIONES RELACIONADAS CON PRENDAS ( CREACIÓN, OBTENCIÓN, FILTRADO, APROBACIÓN, RECHAZO, ETC. )

    // FUNCION PARA CREAR UNA PRENDA NUEVA ( CON ESTADO PENDIENTE DE REVISIÓN )
    
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

    // FUNCION PARA VERIFICAR SI EXISTE UNA RELACIÓN VÁLIDA ENTRE UN TIPO DE PRENDA Y UN COLEGIO

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

    // FUNCION PARA OBTENER EL PRECIO ESTÁNDAR DE UNA PRENDA SEGÚN SU TIPO Y ESTADO DE CALIDAD

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

    // FUNCION PARA OBTENER TODAS LAS PRENDAS PUBLICADAS

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

    // FUNCION PARA OBTENER PRENDAS PENDIENTES DE REVISIÓN (CON FILTRO DE BÚSQUEDA POR NOMBRE O EMAIL DEL VENDEDOR)

    public function obtenerPendientes($pdo, $busqueda = '')
    {
        $sql = "SELECT 
                p.id,
                p.imagen,
                tp.nombre AS tipo,
                c.nombre AS colegio,
                u.nombre AS vendedor,
                u.apellido1,
                u.email,
                ec.nombre AS estado
            FROM prendas p
            JOIN usuarios u ON p.usuario_id = u.id
            JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
            JOIN colegios c ON p.colegio_id = c.id
            JOIN estados_calidad ec ON p.estado_calidad_id = ec.id
            WHERE p.estado_publicacion = 'pendiente'";

        // Filtro de búsqueda por nombre o email del vendedor

        if (!empty($busqueda)) {

            $sql .= " AND (
                    u.nombre LIKE :buscar
                    OR u.email LIKE :buscar
                  )";
        }

        $stmt = $pdo->prepare($sql);

        // Bind del parámetro de búsqueda si se ha proporcionado una cadena de búsqueda válida

        if (!empty($busqueda)) {

            $stmt->bindValue(':buscar', "%$busqueda%");
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    // FUNCION PARA OBTENER UNA PRENDA POR SU ID

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

    // FUNCION PARA APROBAR UNA PRENDA PENDIENTE

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

    // FUNCION PARA RECHAZAR UNA PRENDA PENDIENTE

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

    // FUNCION PARA OBTENER PRENDAS POR USUARIO Y ESTADO DE PUBLICACIÓN

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

    // FUNCION QUE FILTRA PRENDAS EN EL CATÁLOGO SEGÚN COLEGIO, TIPO Y ESTADO DE CALIDAD ( EXCLUYENDO LAS DEL USUARIO LOGEADO )

    public function filtrar($colegio, $tipo, $estado, $usuarioId)
    {
        $sql = "
        SELECT p.*, 
            c.nombre AS colegio,
            t.nombre AS tipo,
            e.nombre AS estado,
            u.nombre AS vendedor

        FROM prendas p

        JOIN colegios c 
            ON p.colegio_id = c.id

        JOIN tipos_prenda t 
            ON p.tipo_prenda_id = t.id

        JOIN estados_calidad e 
            ON p.estado_calidad_id = e.id

        JOIN usuarios u 
            ON p.usuario_id = u.id

        WHERE p.estado_publicacion = 'publicada'
        ";

        $params = [];

        // Excluir prendas del usuario logeado

        if ($usuarioId !== null) {

            $sql .= " AND p.usuario_id != ?";
            $params[] = $usuarioId;
        }

        if (!empty($colegio)) {

            $sql .= " AND p.colegio_id = ?";
            $params[] = $colegio;
        }

        if (!empty($tipo)) {

            $sql .= " AND p.tipo_prenda_id = ?";
            $params[] = $tipo;
        }

        if (!empty($estado)) {

            $sql .= " AND p.estado_calidad_id = ?";
            $params[] = $estado;
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
