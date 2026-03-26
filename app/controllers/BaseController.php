<?php

namespace App\Controllers;

class BaseController
{
    protected function checkLogin()
    {
        if (!isset($_SESSION['usuario'])) {
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/login");
            exit;
        }
    }

    protected function checkAdmin()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
            exit;
        }
    }
}