<?php

namespace App\Controllers;
use App\Services\PrendaService;
use App\Controllers\BaseController;

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

        $this->view('prendas/solicitar', [
            'tiposPrenda' => $tiposPrenda,
            'colegios' => $colegios,
            'estados' => $estados,
            'tallas' => $tallas,
            'generos' => $generos
        ]);
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

        $this->view('prendas/misVentas', [
            'enVenta' => $enVenta,
            'vendidas' => $vendidas,
            'pendientes' => $pendientes,
            'rechazadas' => $rechazadas
        ]);
    }

    // Catálogo de prendas
        public function catalogo()
    {
        $colegio = $_GET['colegio'] ?? null;
        $tipo = $_GET['tipo'] ?? null;
        $estado = $_GET['estado'] ?? null;

        // 🔹 datos para filtros (IMPORTANTE)
        $datos = $this->service->obtenerDatosFormulario($colegio ?: null);

        // 🔹 prendas filtradas
        $prendas = $this->service->filtrar($colegio, $tipo, $estado);

        $this->view('prendas/catalogo', [
            'prendas' => $prendas,
            'colegios' => $datos['colegios'],
            'tiposPrenda' => $datos['tiposPrenda'], // ← filtrados por colegio
            'estadosCalidad' => $datos['estados']
        ]);
    }

    // Página para insertar una prenda (solo admin)
    public function createAdmin()
    {
        $this->checkAdmin();

        // Puedes reutilizar lógica de create()
        $colegioSeleccionado = $_GET['colegio'] ?? null;

        $datos = $this->service->obtenerDatosFormulario($colegioSeleccionado);

        $this->view('admin/insertarPrenda', $datos);
    }

    // Gestiona el envío del formulario de inserción por parte del admin
    public function storeAdmin()
    {
        $this->checkAdmin();

        $data = $_POST;
        $file = $_FILES['archivoEnviado'] ?? null;

        $usuario_id = $_SESSION['usuario']['id'];

        try {
            $this->service->crearPrenda($data, $file, $usuario_id);

            $_SESSION['success_prenda'] = "Prenda insertada correctamente";
        } catch (\Exception $e) {
            $_SESSION['error_campos'] = $e->getMessage();
        }

        header("Location: /admin/prendas/insertar");
        exit;
    }
}