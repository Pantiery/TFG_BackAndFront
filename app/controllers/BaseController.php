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

    protected function checkAdmin()
    {
        $this->checkLogin();

        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
            exit;
        }
    }
}