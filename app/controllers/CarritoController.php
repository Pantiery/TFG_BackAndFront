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

            return $this->jsonResponse(
                false,
                'No se ha recibido ninguna prenda'
            );
        }

        $pdo = \App\Core\Database::getConnection();

        $stmt = $pdo->prepare(
            'SELECT usuario_id FROM prendas WHERE id = ?'
        );

        $stmt->execute([$prendaId]);

        $prenda = $stmt->fetch();

        if (!$prenda) {

            return $this->jsonResponse(
                false,
                'La prenda no existe'
            );
        }

        if ($prenda['usuario_id'] == $usuarioId) {

            return $this->jsonResponse(
                false,
                'No puedes comprar tu propia prenda'
            );
        }

        $carritoService = new CarritoService();

        $carrito = $carritoService->getByUserId($usuarioId);

        if (!$carrito) {
            $carrito = $carritoService->create($usuarioId);
        }

        $anadido = $carritoService->addItem(
            $carrito['id'],
            $prendaId
        );

        if ($anadido) {

            $totalItems = count(
                $carritoService->getItems($carrito['id'])
            );

            return $this->jsonResponse(
                true,
                'Prenda añadida al carrito',
                '/prendas/catalogo',
                [
                    'totalItems' => $totalItems
                ]
            );
        }

        return $this->jsonResponse(
            false,
            'La prenda ya está en el carrito o vendida'
        );
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
            'productos' => $productos,
        ]);
    }

    // ELIMINAR DEL CARRITO
    public function remove()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];
        $prendaId = $_POST['prenda_id'] ?? null;

        if (!$prendaId) {
            header('Location: ' . \App\Config\App::baseUrl() . '/carrito');
            exit;
        }

        $carritoService = new CarritoService();

        $carrito = $carritoService->getByUserId($usuarioId);

        if ($carrito) {

            $carritoService->removeItem($carrito['id'], $prendaId);

            $_SESSION['mensaje_exito'] =
                'Producto eliminado del carrito correctamente';
        }

        header('Location: ' . \App\Config\App::baseUrl() . '/carrito');
        exit;
    }
}
