<?php

session_start();

// obtener ruta
$uri = $_SERVER['REQUEST_URI'];
$uri = explode('?', $uri)[0];
$uri = str_replace('/proyecto_TFG/TFG_BackAndFront/public', '', $uri);

// método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// cargar router
require_once __DIR__ . '/../app/Core/Router.php';

// cargar controllers (temporal)
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

use App\Core\Router;

$router = new Router();

// cargar rutas
require_once __DIR__ . '/../routes/web.php';

// ejecutar ruta
$router->resolve($uri, $method);