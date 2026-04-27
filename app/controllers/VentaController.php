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

        $usuarioId = $_SESSION[ 'usuario' ][ 'id' ];

        $carritoService = new CarritoService();
        $items = $carritoService->getItemsByUser( $usuarioId );

        if ( empty( $items ) ) {
            $_SESSION[ 'mensaje_error' ] = 'El carrito está vacío';
            header( 'Location: /carrito' );
            exit;
        }

        $pdo = Database::getConnection();
        $ventaService = new VentaService();

        try {

            $pdo->beginTransaction();

            $ventaId = $ventaService->crearVenta( $usuarioId );

            $ventaService->insertarDetalle( $ventaId, $items );
            $ventaService->actualizarTotal( $ventaId, $items );

            $carrito = $carritoService->getByUserId( $usuarioId );
            if ( $carrito ) {
                $carritoService->vaciarCarrito( $carrito[ 'id' ] );
            }

            $pdo->commit();

            $_SESSION[ 'mensaje_exito' ] = 'Compra realizada correctamente';

        } catch ( \Exception $e ) {

            $pdo->rollBack();

            $_SESSION[ 'mensaje_error' ] = $e->getMessage();
        }

        header( 'Location: ' . \App\Config\App::url( '/carrito' ) );
        exit;
    }

    // VER MIS COMPRAS

    public function misCompras()
 {
        $this->checkLogin();

        $usuarioId = $_SESSION[ 'usuario' ][ 'id' ];

        $ventaService = new VentaService();
        $compras = $ventaService->obtenerComprasPorUsuario( $usuarioId );

        $this->view( 'prendas/misCompras', [
            'compras' => $compras
        ] );
    }
}