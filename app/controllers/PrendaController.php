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

        // 🔹 Validar que el tipo pertenece al colegio
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

        // 🔹 Obtener precio estándar
        $stmtPrecio = $pdo->prepare("
            SELECT precio 
            FROM precios_estandar 
            WHERE tipo_prenda_id = :tipo 
            AND estado_calidad_id = :estado
        ");

        $stmtPrecio->execute([
            'tipo' => $tipoPrenda,
            'estado' => $estadoPrenda
        ]);

        $precio = $stmtPrecio->fetchColumn();

        // SUBIDA DE IMAGEN
        $imagenRuta = null;

        if (!empty($_FILES['archivoEnviado']['name'])) {

            $nombre = time() . '_' . $_FILES['archivoEnviado']['name'];
            $tmp = $_FILES['archivoEnviado']['tmp_name'];

            $rutaDestino = __DIR__ . '/../../public/uploads/' . $nombre;

            if (move_uploaded_file($tmp, $rutaDestino)) {
                $imagenRuta = '/uploads/' . $nombre;
            } else {
                $_SESSION['error_campos'] = "Error al subir la imagen";
                header("Location: ./solicitar");
                exit;
            }
        }

        $usuario_id = $_SESSION['usuario']['id'];

        // 🔹 INSERT con imagen
        $stmt = $pdo->prepare("
        INSERT INTO prendas 
        (usuario_id, tipo_prenda_id, colegio_id, estado_calidad_id, precio_asignado, estado_publicacion, talla_id, genero_id, imagen) 
        VALUES (:usuario_id, :tipo_prenda_id, :colegio_id, :estado_calidad_id, :precio, 'pendiente', :talla_id, :genero_id, :imagen)
        ");

        $stmt->execute([
            'usuario_id' => $usuario_id,
            'tipo_prenda_id' => $tipoPrenda,
            'colegio_id' => $colegio,
            'estado_calidad_id' => $estadoPrenda,
            'precio' => $precio,
            'talla_id' => $talla,
            'genero_id' => $genero,
            'imagen' => $imagenRuta
        ]);

        $_SESSION['success_prenda'] = "Prenda solicitada con éxito";
        header("Location: ./solicitar");
        exit;
    }

    // 🔹 Mis ventas
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

        $stmt = $pdo->prepare($queryBase . " AND p.estado_publicacion = 'publicada'");
        $stmt->execute([$usuarioId]);
        $enVenta = $stmt->fetchAll();

        $stmt = $pdo->prepare($queryBase . " AND p.estado_publicacion = 'vendida'");
        $stmt->execute([$usuarioId]);
        $vendidas = $stmt->fetchAll();

        $stmt = $pdo->prepare($queryBase . " AND p.estado_publicacion = 'pendiente'");
        $stmt->execute([$usuarioId]);
        $pendientes = $stmt->fetchAll();

        $stmt = $pdo->prepare($queryBase . " AND p.estado_publicacion = 'rechazada'");
        $stmt->execute([$usuarioId]);
        $rechazadas = $stmt->fetchAll();

        require __DIR__ . '/../views/prendas/misVentas.php';
    }

    // 🔹 Catálogo
    public function catalogo()
    {
        require __DIR__ . '/../../config/database.php';

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

        $prendas = $stmt->fetchAll();

        require __DIR__ . '/../views/prendas/catalogo.php';
    }
}