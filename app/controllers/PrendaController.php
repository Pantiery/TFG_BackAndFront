<?php

namespace App\Controllers;
class PrendaController extends BaseController
{
    public function create()
    {

        $this->checkLogin();

        require __DIR__ . '/../views/prendas/solicitar.php';
    }

    public function store()
    {
        $this->checkLogin();

        $tipoPrenda = $_POST['tipoPrenda'] ?? '';
        $colegio = $_POST['colegio'] ?? '';
        $estadoPrenda = $_POST['estadoPrenda'] ?? '';

        if (!is_numeric($tipoPrenda) || !is_numeric($colegio) || !is_numeric($estadoPrenda)) {
            $_SESSION['error_campos'] = "Datos inválidos";
            header("Location: /prendas/solicitar");
            exit;
        }

        require __DIR__ . '/../../config/database.php';

        $usuario_id = $_SESSION['usuario']['id'];

        $stmt = $pdo->prepare("
        INSERT INTO prendas 
        (usuario_id, tipo_prenda_id, colegio_id, estado_calidad_id, precio_asignado, estado_publicacion) 
        VALUES 
        (:usuario_id, :tipo_prenda_id, :colegio_id, :estado_calidad_id, 0, 'pendiente')
    ");

        $stmt->execute([
            'usuario_id' => $usuario_id,
            'tipo_prenda_id' => $tipoPrenda,
            'colegio_id' => $colegio,
            'estado_calidad_id' => $estadoPrenda
        ]);

        $_SESSION['success_prenda'] = "Prenda solicitada con éxito";
        header("Location: /prendas/solicitar");
        exit;
    }
}