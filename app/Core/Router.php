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
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $base = dirname($_SERVER['SCRIPT_NAME']);
        $uri = str_replace($base, '', $uri);

        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        $callback = $this->routes[$httpMethod][$uri] ?? null;

        if (!$callback) {
            http_response_code(404);
            echo "404 - Ruta no encontrada";
            return;
        }

        if (is_array($callback)) {
            $controller = new $callback[0];
            $action = $callback[1];
            $controller->$action();
        } else {
            call_user_func($callback);
        }
    }
}