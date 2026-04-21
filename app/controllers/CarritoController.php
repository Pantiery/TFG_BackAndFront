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

        $prendaId = $_POST['prenda_id'] ?? null;
        $usuarioId = $_SESSION['usuario']['id'];

        if (!$prendaId) {
            $_SESSION['mensaje_error'] = "No se ha recibido ninguna prenda.";
            header("Location: " . \App\Config\App::baseUrl() . "/prendas/catalogo");
            exit;
        }

        $carritoService = new CarritoService();

        $carrito = $carritoService->getByUserId($usuarioId);

        if (!$carrito) {
            $carrito = $carritoService->create($usuarioId);
        }

        $anadido = $carritoService->addItem($carrito['id'], $prendaId);

        if ($anadido) {
            $_SESSION['mensaje_exito'] = "Prenda añadida al carrito con éxito";
        } else {
            $_SESSION['mensaje_error'] = "Esa prenda ya está en tu carrito";
        }

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