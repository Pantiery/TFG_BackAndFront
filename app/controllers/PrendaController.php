<?php

namespace App\Controllers;

use App\Services\PrendaService;
use App\Controllers\BaseController;
use App\Config\App;

class PrendaController extends BaseController
{
    private $service;

    public function __construct()
    {
        $this->service = new PrendaService();
    }

    // PAGINA DE SOLICITUD DE PRENDA

    public function create()
    {
        $this->checkLogin();

        $colegioSeleccionado = $_GET['colegio'] ?? null;

        $datos = $this->service->obtenerDatosFormulario($colegioSeleccionado);

        $this->view('prendas/solicitar', $datos);
    }

    // GESTIONAR ENVÍO DE SOLICITUD DE PRENDA

    public function store()
    {
        $this->checkLogin();

        // permite solo POST e impide accesos directos

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . App::url('/prendas/solicitar'));
            exit;
        }

        $data = $_POST;
        $file = $_FILES['archivoEnviado'] ?? null;
        $usuario_id = $_SESSION['usuario']['id'];

        // Validación básica de archivo ( antes del service )

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['mensaje_error'] = 'Debes subir una imagen válida';
            header('Location: ' . App::url('/prendas/solicitar'));
            exit;
        }

        try {
            $this->service->crearPrenda($data, $file, $usuario_id);

            $_SESSION['mensaje_exito'] = 'Prenda solicitada con éxito';
        } catch (\Exception $e) {
            $_SESSION['mensaje_error'] = $e->getMessage();
        }

        header('Location: ' . App::url('/prendas/solicitar'));
        exit;
    }

    // PAGINA DE MIS VENTAS

    public function misVentas()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];

        $datos = $this->service->obtenerMisVentas($usuarioId);

        $this->view('prendas/misVentas', $datos);
    }

    // PAGINA DE CATÁLOGO DE PRENDAS

    public function catalogo()
    {
        $colegio = $_GET['colegio'] ?? null;
        $tipo = $_GET['tipo'] ?? null;
        $estado = $_GET['estado'] ?? null;

        $datos = $this->service->obtenerDatosFormulario($colegio ?: null);
        $usuarioId = $_SESSION['usuario']['id'] ?? null;
        $prendas = $this->service->filtrar($colegio, $tipo, $estado, $usuarioId);

        $this->view('prendas/catalogo', [
            'prendas' => $prendas,
            'colegios' => $datos['colegios'],
            'tiposPrenda' => $datos['tiposPrenda'],
            'estadosCalidad' => $datos['estados'],
        ]);
    }
}
