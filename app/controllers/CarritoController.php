<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\CarritoService;

class CarritoController extends BaseController
{
    // AÑADIR AL CARRITO
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

    // VER CARRITO
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

    // ELIMINAR DEL CARRITO
        public function remove()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];
        $prendaId = $_POST['prenda_id'] ?? null;

        if (!$prendaId) {
            header("Location: " . \App\Config\App::baseUrl() . "/carrito");
            exit;
        }

        $carritoService = new CarritoService();

        $carrito = $carritoService->getByUserId($usuarioId);

        if ($carrito) {
            $carritoService->removeItem($carrito['id'], $prendaId);
        }

        header("Location: " . \App\Config\App::baseUrl() . "/carrito");
        exit;
    }
}