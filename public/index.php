<?php

session_start();

//AUTOLOAD (CARGA AUTOMATICA DE CLASES)
spl_autoload_register(function ($class) {
    $class = str_replace('App\\', '', $class);
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../app/' . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// obtener ruta
$uri = $_SERVER['REQUEST_URI'];
$uri = explode('?', $uri)[0];
$uri = str_replace('/proyecto_TFG/TFG_BackAndFront/public', '', $uri);

// método HTTP
$method = $_SERVER['REQUEST_METHOD'];

use App\Core\Router;

$router = new Router();

// cargar rutas
require_once __DIR__ . '/../routes/web.php';

// ejecutar ruta
$router->resolve($uri, $method);