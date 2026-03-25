<?php

//cargo controllers

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

//rutas simples

if ($uri === '/') {
    $controller = new HomeController();
    $controller->index();

}elseif ($uri === '/login') {

    $controller = new AuthController();

    if ($_SERVER['REQUEST_METHOD']=== 'GET') {
        $controller->showLogin();    
    }
    if ($_SERVER['REQUEST_METHOD']=== 'POST') {
        $controller->login();
    }

} else {
    echo "404 no existe la pagina";
}