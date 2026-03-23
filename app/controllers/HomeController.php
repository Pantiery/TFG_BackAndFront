<?php

namespace App\Controllers;

class HomeController {

    public function index() {

        if (!isset($_SESSION['user'])) {
            header('Location: /proyecto_TFG/TFG_BackAndFront/public/login');
            exit;
        }

        require '../views/home.php';
    }

}