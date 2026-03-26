<?php

namespace App\Controllers;
class HomeController extends BaseController{

    public function index() {

        $user = $_SESSION['usuario'] ?? null;

        require_once __DIR__ . '/../views/prendas/home.php';
    }

}