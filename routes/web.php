<?php

//rutas simples

if ($uri === '/') {
    echo "estas en home";
}elseif ($uri === '/login') {
    echo "estas en login";
} else {
    echo "404 error";
}