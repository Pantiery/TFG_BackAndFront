<?php

// obtener ruta (URL)

$uri = $_SERVER['REQUEST_URI'];

//quita todo lo que este por delante de la url (?lo que sea=...)

$uri = explode('?', $uri)[0];

//quita /public si aparece

$uri = str_replace('/proyecto_TFG/TFG_BackAndFront/public', '', $uri);

//rutas simples

if ($uri === '/') {
    echo "estas en home";
}elseif ($uri === '/login') {
    echo "estas en login";
} else {
    echo "404 error";
}
