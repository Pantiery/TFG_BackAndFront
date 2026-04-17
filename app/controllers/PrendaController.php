<?php

namespace App\Controllers;
use App\Services\PrendaService;

class PrendaController extends BaseController
{

private $service;
    public function __construct()
    {
        $this->service = new PrendaService();
    }

// Página para solicitar una prenda
    public function create()
    {
        $this->checkLogin();

        $colegioSeleccionado = $_GET['colegio'] ?? null;

        $datos = $this->service->obtenerDatosFormulario($colegioSeleccionado);

        $tiposPrenda = $datos['tiposPrenda'];
        $colegios = $datos['colegios'];
        $estados = $datos['estados'];
        $tallas = $datos['tallas'];
        $generos = $datos['generos'];

        require __DIR__ . '/../views/prendas/solicitar.php';
    }

    // Gestiona el envío del formulario delegando la lógica al service
    public function store()
{
    $this->checkLogin();

    $data = $_POST;
    $file = $_FILES['archivoEnviado'] ?? null;

    $usuario_id = $_SESSION['usuario']['id'];

    try {
        $this->service->crearPrenda($data, $file, $usuario_id);

        $_SESSION['success_prenda'] = "Prenda solicitada con éxito";
    } catch (\Exception $e) {
        $_SESSION['error_campos'] = $e->getMessage();
    }

    header("Location: ./solicitar");
    exit;
}

    // Página de mis ventas
    public function misVentas()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];

        $datos = $this->service->obtenerMisVentas($usuarioId);

        $enVenta = $datos['enVenta'];
        $vendidas = $datos['vendidas'];
        $pendientes = $datos['pendientes'];
        $rechazadas = $datos['rechazadas'];

        require __DIR__ . '/../views/prendas/misVentas.php';
    }

    // Catálogo de prendas
    public function catalogo()
    {
        $prendas = $this->service->obtenerCatalogo();

        require __DIR__ . '/../views/prendas/catalogo.php';
    }
}