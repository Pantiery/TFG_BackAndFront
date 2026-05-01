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

    // Página para solicitar una prenda

    public function create()
    {
        $this->checkLogin();

        $colegioSeleccionado = $_GET['colegio'] ?? null;

        $datos = $this->service->obtenerDatosFormulario($colegioSeleccionado);

        $this->view('prendas/solicitar', $datos);
    }

    // Gestiona el envío del formulario delegando la lógica al service

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
            $_SESSION['error_campos'] = 'Debes subir una imagen válida';
            header('Location: ' . App::url('/prendas/solicitar'));
            exit;
        }

        try {
            $this->service->crearPrenda($data, $file, $usuario_id);

            $_SESSION['success_prenda'] = 'Prenda solicitada con éxito';
        } catch (\Exception $e) {
            $_SESSION['error_campos'] = $e->getMessage();
        }

        header('Location: ' . App::url('/prendas/solicitar'));
        exit;
    }

    // Página de mis ventas

    public function misVentas()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];

        $datos = $this->service->obtenerMisVentas($usuarioId);

        $this->view('prendas/misVentas', $datos);
    }

    // Catálogo de prendas

    public function catalogo()
    {
        $colegio = $_GET['colegio'] ?? null;
        $tipo = $_GET['tipo'] ?? null;
        $estado = $_GET['estado'] ?? null;

        $datos = $this->service->obtenerDatosFormulario($colegio ?: null);
        $usuarioId = $_SESSION['usuario']['id'];
        $prendas = $this->service->filtrar($colegio, $tipo, $estado, $usuarioId);

        $this->view('prendas/catalogo', [
            'prendas' => $prendas,
            'colegios' => $datos['colegios'],
            'tiposPrenda' => $datos['tiposPrenda'],
            'estadosCalidad' => $datos['estados'],
        ]);
    }

    // Página para insertar una prenda ( solo admin )

    public function createAdmin()
    {
        $this->checkAdmin();

        $colegioSeleccionado = $_GET['colegio'] ?? null;

        $datos = $this->service->obtenerDatosFormulario($colegioSeleccionado);

        $this->view('admin/insertarPrenda', $datos);
    }

    // Gestiona el envío del formulario de inserción por parte del admin

    public function storeAdmin()
    {
        $this->checkAdmin();

        // Seguridad: solo POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . App::url('/admin/prendas/insertar'));
            exit;
        }

        $data = $_POST;
        $file = $_FILES['archivoEnviado'] ?? null;
        $usuario_id = $_SESSION['usuario']['id'];

        // Validación archivo
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error_campos'] = 'Debes subir una imagen válida';
            header('Location: ' . App::url('/admin/prendas/insertar'));
            exit;
        }

        try {
            $this->service->crearPrenda($data, $file, $usuario_id);

            $_SESSION['success_prenda'] = 'Prenda insertada correctamente';
        } catch (\Exception $e) {
            $_SESSION['error_campos'] = $e->getMessage();
        }

        header('Location: ' . App::url('/admin/prendas/insertar'));
        exit;
    }
}
