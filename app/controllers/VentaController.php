<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\CarritoService;
use App\Services\VentaService;
use App\Core\Database;

class VentaController extends BaseController
{
    public function comprar()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];

        $carritoService = new CarritoService();
        $items = $carritoService->getItemsByUser($usuarioId);

        if (empty($items)) {
            $_SESSION['mensaje_error'] = 'El carrito está vacío';
            header('Location: ' . \App\Config\App::url('/carrito'));
            exit;
        }

        $pdo = Database::getConnection();
        $ventaService = new VentaService();

        try {
            $pdo->beginTransaction();

            $ventaId = $ventaService->crearVenta($usuarioId);

            $ventaService->insertarDetalle($ventaId, $items);
            $ventaService->actualizarTotal($ventaId, $items);

            $carrito = $carritoService->getByUserId($usuarioId);
            if ($carrito) {
                $carritoService->vaciarCarrito($carrito['id']);
            }

            $pdo->commit();

            $_SESSION['mensaje_exito'] = 'Compra realizada correctamente';
        } catch (\Exception $e) {
            $pdo->rollBack();

            $_SESSION['mensaje_error'] = $e->getMessage();
        }

        header('Location: ' . \App\Config\App::url('/carrito'));
        exit;
    }

    // VER MIS COMPRAS

    public function misCompras()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];

        $ventaService = new VentaService();
        $compras = $ventaService->obtenerComprasPorUsuario($usuarioId);

        $this->view('prendas/misCompras', [
            'compras' => $compras,
        ]);
    }

    // VER MIS VENTAS

    public function misVentas()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];

        $ventaService = new VentaService();

        $ventas = $ventaService->obtenerVentasPorUsuario($usuarioId);

        $totalGanado = 0;

        foreach ($ventas as $venta) {
            $totalGanado += $venta['importe_vendedor'];
        }

        $this->view('prendas/misVentas', [
            'ventas' => $ventas,
            'totalGanado' => $totalGanado
        ]);
    }

    // VER MIS VENTAS
    public function monedero()
    {
        $this->checkLogin();

        $usuarioId = $_SESSION['usuario']['id'];

        $ventaService = new VentaService();

        $ventas = $ventaService->obtenerVentasPendientes($usuarioId);
        $total = $ventaService->calcularTotalPendiente($ventas);

        $this->view('usuario/monedero', [
            'ventas' => $ventas,
            'total' => $total
        ]);
    }

    // TEST DETALLE VENTA
public function testDetalle()
{
    $this->checkLogin();

    $ventaService = new VentaService();

    // CAMBIAR POR UNA VENTA REAL DE TU BD
    $detalle = $ventaService->obtenerDetalleVenta(1);

    echo '<pre>';
    var_dump($detalle);
    echo '</pre>';
}
}
