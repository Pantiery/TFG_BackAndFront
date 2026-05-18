<?php

require_once __DIR__ . '/../app/Core/Autoload.php';

use App\Core\Router;
use App\Core\Env;

session_start();

// Cierro de sesión por inactividad
$tiempo_inactividad = 1200; // 20 minutos en segundos
if (isset($_SESSION['ultima_actividad'])) {
    if (time() - $_SESSION['ultima_actividad'] > $tiempo_inactividad) {
        session_unset();
        session_destroy();

        session_start();
        $_SESSION['mensaje_error'] = 'Tu sesión ha expirado por inactividad. Vuelve a iniciar sesión.';

        header('Location: ' . \App\Config\App::url('/login'));
        exit;
    }
}

// Reseteo el tiempo de actividad
$_SESSION['ultima_actividad'] = time();

// URI solicitada
$uri = explode('?', $_SERVER['REQUEST_URI'])[0];
$uri = str_replace('/proyecto_TFG/TFG_BackAndFront/public', '', $uri);

// Método HTTP solicitado
$method = $_SERVER['REQUEST_METHOD'];

// Cargar variables de entorno
Env::load(__DIR__ . '/../.env');
$router = new Router();

// cargar rutas
require_once __DIR__ . '/../routes/web.php';

// ejecutar ruta
$router->resolve($uri, $method);
