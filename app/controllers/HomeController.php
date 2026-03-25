<?php

class HomeController {

    public function index() {

        $user = $_SESSION['user'] ?? null;

        require_once __DIR__ . '/../views/prendas/home.php';
    }

}