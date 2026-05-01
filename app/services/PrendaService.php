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
            'tipo' => $tipo,
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
            'estado' => $estado,
        ]);

        $precio = $stmt->fetchColumn();

        if ($precio === false) {
            throw new \Exception('No existe precio definido para esta prenda');
        }

        return $precio;
    }

    public function obtenerCatalogo($usuarioId)
    {
        $pdo = Database::getConnection();
        return $this->prendaModel->obtenerPublicadas($pdo, $usuarioId);
    }

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

    public function obtenerDatosFormulario($colegioSeleccionado = null)
    {
        $pdo = Database::getConnection();

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
            $tiposPrenda = $pdo->query('SELECT id, nombre FROM tipos_prenda')->fetchAll();
        }

        return [
            'tiposPrenda' => $tiposPrenda,
            'colegios' => $pdo->query('SELECT id, nombre FROM colegios')->fetchAll(),
            'estados' => $pdo->query('SELECT id, nombre FROM estados_calidad')->fetchAll(),
            'tallas' => $pdo->query('SELECT id, nombre FROM tallas ORDER BY id')->fetchAll(),
            'generos' => $pdo->query('SELECT id, nombre FROM generos')->fetchAll(),
        ];
    }

    // 🔥 MÉTODO IMPORTANTE MEJORADO

    public function crearPrenda($data, $file, $usuario_id)
    {
        $pdo = Database::getConnection();

        // 🔹 1. Validar campos obligatorios
        $campos = ['tipoPrenda', 'colegio', 'estadoPrenda', 'talla', 'genero'];

        foreach ($campos as $campo) {
            if (empty($data[$campo])) {
                throw new \Exception("El campo {$campo} es obligatorio");
            }
        }

        // 🔹 2. Validar tipos numéricos
        foreach ($campos as $campo) {
            if (!is_numeric($data[$campo])) {
                throw new \Exception("Datos inválidos en {$campo}");
            }
        }

        // 🔹 3. Convertir a enteros ( seguridad extra )
        $tipo = (int) $data['tipoPrenda'];
        $colegio = (int) $data['colegio'];
        $estado = (int) $data['estadoPrenda'];
        $talla = (int) $data['talla'];
        $genero = (int) $data['genero'];

        // 🔹 4. Validar relación tipo ↔ colegio
        if (!$this->validarTipoColegio($pdo, $colegio, $tipo)) {
            throw new \Exception('Esa prenda no pertenece a ese colegio');
        }

        // 🔹 5. Obtener precio ( ya valida internamente )
        $precio = $this->obtenerPrecio($pdo, $tipo, $estado);

        // 🔹 6. Subir imagen ( puede lanzar excepción )
        $uploadService = new UploadService();
        $imagenRuta = $uploadService->subir($file);

        // 🔹 7. Guardar en BD con control de errores
        try {
            $this->prendaModel->crear($pdo, [
                'usuario_id' => $usuario_id,
                'tipo_prenda_id' => $tipo,
                'colegio_id' => $colegio,
                'estado_calidad_id' => $estado,
                'precio' => $precio,
                'talla_id' => $talla,
                'genero_id' => $genero,
                'imagen' => $imagenRuta,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Error al guardar la prenda en la base de datos');
        }
    }

    // FILTRAR CATALOGO ( método mejorado con validación y seguridad )
    public function filtrar($colegio, $tipo, $estado, $usuarioId)
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

        // SOLO SI HAY USUARIO LOGEADO
        if ($usuarioId !== null) {
            $sql .= " AND p.usuario_id != ?";
            $params[] = $usuarioId;
        }

        if (!empty($colegio)) {
            $sql .= ' AND p.colegio_id = ?';
            $params[] = $colegio;
        }

        if (!empty($tipo)) {
            $sql .= ' AND p.tipo_prenda_id = ?';
            $params[] = $tipo;
        }

        if (!empty($estado)) {
            $sql .= ' AND p.estado_calidad_id = ?';
            $params[] = $estado;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
