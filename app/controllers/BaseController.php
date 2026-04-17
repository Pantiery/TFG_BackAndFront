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
        extract($data);

        $archivo = __DIR__ . '/../views/' . $ruta . '.php';

        if (!file_exists($archivo)) {
            die("Vista no encontrada: " . $ruta);
        }

        require $archivo;
    }
}