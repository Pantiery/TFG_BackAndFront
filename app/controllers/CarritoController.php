<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\CarritoService;

class CarritoController extends BaseController
{
    public function add()
    {
        $this->checkLogin();

        $prendaId = $_POST['prenda_id'];
        $usuarioId = $_SESSION['usuario']['id'];

        $carritoService = new CarritoService();

        $carrito = $carritoService->getByUserId($usuarioId);

        if (!$carrito) {
            $carrito = $carritoService->create($usuarioId);
        }

        $carritoService->addItem($carrito['id'], $prendaId);

        header("Location: " . \App\Config\App::baseUrl() . "/prendas/catalogo");
        exit;
    }


    public function index()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];

        $carritoService = new CarritoService();

        $carrito = $carritoService->getByUserId($usuarioId);

        $productos = [];

        if ($carrito) {
            $productos = $carritoService->getItems($carrito['id']);
        }

        $this->view('carrito/index', [
            'productos' => $productos
        ]);
    }
}