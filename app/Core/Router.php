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

    public function resolve($uri, $method)
    {
        $callback = $this->routes[$method][$uri] ?? null;

        if (!$callback) {
            http_response_code(404);
            echo "404 - Ruta no encontrada";
            return;
        }

        [$controller, $action] = $callback;

        $controllerInstance = new $controller();
        $controllerInstance->$action();
    }
}