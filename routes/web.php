<?php

//cargo controllers

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

//rutas simples

if ($uri === '/') {
    $controller = new HomeController();
    $controller->index();

} elseif ($uri === '/login') {

    $controller = new AuthController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller->showLogin();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->login();
    }

} elseif ($uri === '/logout') {

    session_destroy();

    header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
    exit;
} elseif ($uri === '/register') {

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->showRegister();
    }
    
    header("localhost/proyecto_TFG/TFG_BackAndFront/public/register.php");
}

else {
    echo "404 no existe la pagina";
}