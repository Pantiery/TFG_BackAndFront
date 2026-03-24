<?php

//cargo controller

require_once __DIR__ . '/../app/Controllers/AuthController.php';

//rutas simples

if ($uri === '/') {
    echo "estas en home";

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