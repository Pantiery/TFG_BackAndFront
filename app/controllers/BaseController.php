<?php

namespace App\Controllers;

class BaseController
{
    // METODOS PARA VERIFICAR ACCESO A RUTAS PROTEGIDAS
    protected function checkLogin()
    {
        if (!isset($_SESSION['usuario'])) {
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/login");
            exit;
        }
    }

    // SOLO PARA ADMINISTRADORES
    protected function checkAdmin()
    {
        $this->checkLogin();

        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
            exit;
        }
    }

    // FUNCION PARA CARGAR VISTAS
    protected function view($ruta, $data = [])
{
    // 🔥 Cargar carrito SIEMPRE para el header
    if (isset($_SESSION['usuario'])) {
        $carritoService = new \App\Services\CarritoService();

        $carrito = $carritoService->getByUserId($_SESSION['usuario']['id']);

        $productos = [];

        if ($carrito) {
            $productos = $carritoService->getItems($carrito['id']);
        }

        $data['productos'] = $productos;
    } else {
        $data['productos'] = [];
    }

    extract($data);

    $archivo = __DIR__ . '/../views/' . $ruta . '.php';

    if (!file_exists($archivo)) {
        die("Vista no encontrada: " . $ruta);
    }

    require $archivo;
}
}