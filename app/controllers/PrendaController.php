<?php

namespace App\Controllers;
class PrendaController extends BaseController
{
    public function create()
    {
        $this->checkLogin();

        require __DIR__ . '/../../config/database.php';

        $stmt = $pdo->query("SELECT id, nombre FROM tipos_prenda");
        $tiposPrenda = $stmt->fetchAll();
        $colegios = $pdo->query("SELECT id, nombre FROM colegios")->fetchAll();
        $estados = $pdo->query("SELECT id, nombre FROM estados_calidad")->fetchAll();
        $tallas = $pdo->query("SELECT id, nombre FROM tallas")->fetchAll();
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
}