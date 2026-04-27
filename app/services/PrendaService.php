<?php

namespace App\Services;
use App\Core\Database;
use App\Services\UploadService;


class PrendaService
{
    private $prendaModel;
    public function __construct()
    {
        $this->prendaModel = new \App\Models\Prenda();
    }

    // Validar que el tipo de prenda sea compatible con el colegio seleccionado
    public function validarTipoColegio($pdo, $colegio, $tipo)
    {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM colegio_tipo_prenda 
            WHERE colegio_id = :colegio 
            AND tipo_prenda_id = :tipo
        ");

        $stmt->execute([
            'colegio' => $colegio,
            'tipo' => $tipo
        ]);

        return $stmt->fetchColumn() > 0;
    }

    // Obtener el precio estándar según el tipo de prenda y su estado de calidad
    public function obtenerPrecio($pdo, $tipo, $estado)
    {
        $stmt = $pdo->prepare("
            SELECT precio 
            FROM precios_estandar 
            WHERE tipo_prenda_id = :tipo 
            AND estado_calidad_id = :estado
        ");

        $stmt->execute([
            'tipo' => $tipo,
            'estado' => $estado
        ]);

        $precio = $stmt->fetchColumn();

        if ($precio === false) {
            throw new \Exception("No existe precio definido");
        }

        return $precio;
    }

    // Función para obtener el catálogo de prendas publicadas
    public function obtenerCatalogo()
    {
        $pdo = Database::getConnection();

        return $this->prendaModel->obtenerPublicadas($pdo);
    }

    // Función para obtener las prendas de un usuario según su estado de publicación
    public function obtenerMisVentas($usuarioId)
    {
        $pdo = Database::getConnection();

        return [
            'enVenta' => $this->prendaModel->obtenerPorUsuarioYEstado($pdo, $usuarioId, 'publicada'),
            'vendidas' => $this->prendaModel->obtenerPorUsuarioYEstado($pdo, $usuarioId, 'vendida'),
            'pendientes' => $this->prendaModel->obtenerPorUsuarioYEstado($pdo, $usuarioId, 'pendiente'),
            'rechazadas' => $this->prendaModel->obtenerPorUsuarioYEstado($pdo, $usuarioId, 'rechazada'),
        ];
    }

    // Funcion para obtener los datos necesarios para el formulario de solicitud de prenda
    public function obtenerDatosFormulario($colegioSeleccionado = null)
    {
        $pdo = Database::getConnection();

        // Tipos de prenda según colegio
        if ($colegioSeleccionado) {
            $stmt = $pdo->prepare("
            SELECT tp.id, tp.nombre
            FROM tipos_prenda tp
            JOIN colegio_tipo_prenda ctp 
            ON tp.id = ctp.tipo_prenda_id
            WHERE ctp.colegio_id = :colegio
        ");

            $stmt->execute(['colegio' => $colegioSeleccionado]);
            $tiposPrenda = $stmt->fetchAll();
        } else {
            $tiposPrenda = $pdo->query("
                SELECT id, nombre FROM tipos_prenda
            ")->fetchAll();
        }

        $colegios = $pdo->query("SELECT id, nombre FROM colegios")->fetchAll();
        $estados = $pdo->query("SELECT id, nombre FROM estados_calidad")->fetchAll();
        $tallas = $pdo->query("SELECT id, nombre FROM tallas ORDER BY id")->fetchAll();
        $generos = $pdo->query("SELECT id, nombre FROM generos")->fetchAll();

        return [
            'tiposPrenda' => $tiposPrenda,
            'colegios' => $colegios,
            'estados' => $estados,
            'tallas' => $tallas,
            'generos' => $generos
        ];
    }

    // Función para crear una nueva prenda en la base de datos
    public function crearPrenda($data, $file, $usuario_id)
    {
        $pdo = Database::getConnection();

        // Validaciones
        if (
            !is_numeric($data['tipoPrenda']) ||
            !is_numeric($data['colegio']) ||
            !is_numeric($data['estadoPrenda']) ||
            !is_numeric($data['talla']) ||
            !is_numeric($data['genero'])
        ) {
            throw new \Exception("Datos inválidos");
        }

        // Validar tipo ↔ colegio
        if (!$this->validarTipoColegio($pdo, $data['colegio'], $data['tipoPrenda'])) {
            throw new \Exception("Esa prenda no pertenece a ese colegio");
        }

        // Obtener precio estándar
        $precio = $this->obtenerPrecio($pdo, $data['tipoPrenda'], $data['estadoPrenda']);

        // Imagen
        $uploadService = new UploadService();
        $imagenRuta = $uploadService->subir($file);

        $this->prendaModel->crear($pdo, [
            'usuario_id' => $usuario_id,
            'tipo_prenda_id' => $data['tipoPrenda'],
            'colegio_id' => $data['colegio'],
            'estado_calidad_id' => $data['estadoPrenda'],
            'precio' => $precio,
            'talla_id' => $data['talla'],
            'genero_id' => $data['genero'],
            'imagen' => $imagenRuta
        ]);
    }

        public function filtrar($colegio, $tipo, $estado)
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT p.*, 
                c.nombre AS colegio,
                t.nombre AS tipo,
                e.nombre AS estado,
                u.nombre AS vendedor
            FROM prendas p
            JOIN colegios c ON p.colegio_id = c.id
            JOIN tipos_prenda t ON p.tipo_prenda_id = t.id
            JOIN estados_calidad e ON p.estado_calidad_id = e.id
            JOIN usuarios u ON p.usuario_id = u.id
            WHERE p.estado_publicacion = 'publicada'
        ";

        $params = [];

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

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}