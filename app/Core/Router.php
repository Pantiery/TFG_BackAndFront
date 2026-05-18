<?php

namespace App\Core;

class Router
{
    private $routes = [];

    // Métodos para registrar rutas GET
    public function get($path, $callback)
    {
        $this->routes[ 'GET' ][ $path ] = $callback;
    }

    // Método para registrar rutas POST
    public function post($path, $callback)
    {
        $this->routes[ 'POST' ][ $path ] = $callback;
    }

    // Método para resolver la ruta solicitada y ejecutar el controlador correspondiente
    public function resolve($uri, $method)
    {
        // Obtener solo la ruta sin parámetros y normalizarla
        $uri = parse_url($uri, PHP_URL_PATH);

        // Quitar index.php si aparece
        $uri = str_replace('/index.php', '', $uri);

        // Quitar la base del proyecto ( /proyecto_TFG/.../public )
        $base = dirname($_SERVER[ 'SCRIPT_NAME' ]);
        if ($base !== '/' && strpos($uri, $base) === 0) {
            $uri = substr($uri, strlen($base));
        }

        // Normalizar formato
        $uri = '/' . trim($uri, '/');

        $callback = $this->routes[ $method ][ $uri ] ?? null;

        if (!$callback) {
            http_response_code(404);
            echo '404 - Ruta no encontrada';
            return;
        }

        [ $controller, $action ] = $callback;

        $controllerInstance = new $controller();
        $controllerInstance->$action();
    }
}
