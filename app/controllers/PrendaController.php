<?php

namespace App\Controllers;
class PrendaController extends BaseController
{
    public function create()
    {
        $this->checkLogin();

        require __DIR__ . '/../../config/database.php';

        $colegioSeleccionado = $_GET['colegio'] ?? null;

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
            $tiposPrenda = [];
        }

        $colegios = $pdo->query("SELECT id, nombre FROM colegios")->fetchAll();
        $estados = $pdo->query("SELECT id, nombre FROM estados_calidad")->fetchAll();
        $tallas = $pdo->query("SELECT id, nombre FROM tallas ORDER BY id")->fetchAll();
        $generos = $pdo->query("SELECT id, nombre FROM generos")->fetchAll();

        require __DIR__ . '/../views/prendas/solicitar.php';
    }

    public function store()
    {
        $this->checkLogin();

        $tipoPrenda = $_POST['tipoPrenda'] ?? '';
        $colegio = $_POST['colegio'] ?? '';
        $estadoPrenda = $_POST['estadoPrenda'] ?? '';
        $talla = $_POST['talla'] ?? '';
        $genero = $_POST['genero'] ?? '';

        if (
            !is_numeric($tipoPrenda) ||
            !is_numeric($colegio) ||
            !is_numeric($estadoPrenda) ||
            !is_numeric($talla) ||
            !is_numeric($genero)
        ) {
            $_SESSION['error_campos'] = "Datos inválidos";
            header("Location: ./solicitar");
            exit;
        }

        require __DIR__ . '/../../config/database.php';

        $stmtCheck = $pdo->prepare("
            SELECT COUNT(*) 
            FROM colegio_tipo_prenda 
            WHERE colegio_id = :colegio 
            AND tipo_prenda_id = :tipo
        ");

        $stmtCheck->execute([
            'colegio' => $colegio,
            'tipo' => $tipoPrenda
        ]);

        if ($stmtCheck->fetchColumn() == 0) {
            $_SESSION['error_campos'] = "Esa prenda no pertenece a ese colegio";
            header("Location: ./solicitar");
            exit;
        }

        $stmtPrecio = $pdo->prepare("
            SELECT precio 
            FROM precios_estandar 
            WHERE tipo_prenda_id = :tipo 
            AND estado_calidad_id = :estado");

        $stmtPrecio->execute([
            'tipo' => $tipoPrenda,
            'estado' => $estadoPrenda
        ]);

        $precio = $stmtPrecio->fetchColumn();

        $usuario_id = $_SESSION['usuario']['id'];

        $stmt = $pdo->prepare("
        INSERT INTO prendas 
        (usuario_id, tipo_prenda_id, colegio_id, estado_calidad_id, precio_asignado, estado_publicacion, talla_id, genero_id) 
        VALUES (:usuario_id, :tipo_prenda_id, :colegio_id, :estado_calidad_id, :precio, 'pendiente', :talla_id, :genero_id)");

        $stmt->execute([
            'usuario_id' => $usuario_id,
            'tipo_prenda_id' => $tipoPrenda,
            'colegio_id' => $colegio,
            'estado_calidad_id' => $estadoPrenda,
            'precio' => $precio,
            'talla_id' => $_POST['talla'] ?? '',
            'genero_id' => $_POST['genero'] ?? ''
        ]);

        $_SESSION['success_prenda'] = "Prenda solicitada con éxito";
        header("Location: ./solicitar");
        exit;
    }

    // querys para mostrar las prendas del usuario logueado
    public function misVentas()
    {
        $this->checkLogin();

        require __DIR__ . '/../../config/database.php';

        $usuarioId = $_SESSION['usuario']['id'];

        $queryBase = "
        SELECT p.*, tp.nombre AS tipo, c.nombre AS colegio
        FROM prendas p
        JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
        JOIN colegios c ON p.colegio_id = c.id
        WHERE p.usuario_id = ?
    ";

        // EN VENTA (publicadas)
        $stmt = $pdo->prepare($queryBase . " AND p.estado_publicacion = 'publicada'");
        $stmt->execute([$usuarioId]);
        $enVenta = $stmt->fetchAll();

        // VENDIDAS
        $stmt = $pdo->prepare($queryBase . " AND p.estado_publicacion = 'vendida'");
        $stmt->execute([$usuarioId]);
        $vendidas = $stmt->fetchAll();

        // PENDIENTES
        $stmt = $pdo->prepare($queryBase . " AND p.estado_publicacion = 'pendiente'");
        $stmt->execute([$usuarioId]);
        $pendientes = $stmt->fetchAll();

        // RECHAZADAS
        $stmt = $pdo->prepare($queryBase . " AND p.estado_publicacion = 'rechazada'");
        $stmt->execute([$usuarioId]);
        $rechazadas = $stmt->fetchAll();

        require __DIR__ . '/../views/prendas/misVentas.php';
    }
}