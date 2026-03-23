<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

   public function resolve()
{
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // quitar base del proyecto
    $base = '/proyecto_TFG/TFG_BackAndFront/public';
    $uri = str_replace($base, '', $uri);

    // normalizar URI
    $uri = rtrim($uri, '/');
    if ($uri === '') {
        $uri = '/';
    }

    $callback = $this->routes[$method][$uri] ?? null;

    if (!$callback) {
        echo "Ruta no encontrada: " . $uri; // 👈 DEBUG
        return;
    }

    if (is_array($callback)) {
        $controller = new $callback[0];
        $method = $callback[1];
        $controller->$method();
    } else {
        call_user_func($callback);
    }
}
}