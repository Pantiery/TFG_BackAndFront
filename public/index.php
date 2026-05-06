<?php

require_once __DIR__ . '/../app/Core/Autoload.php';

session_start();

//CIERRE DE SESION POR INACTIVIDAD
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

//RESETEO EL TIEMPO DE INACTIVIDAD
$_SESSION['ultima_actividad'] = time();

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
use App\Core\Env;

Env::load(__DIR__ . '/../.env');
$router = new Router();

// cargar rutas
require_once __DIR__ . '/../routes/web.php';

// ejecutar ruta
$router->resolve($uri, $method);
