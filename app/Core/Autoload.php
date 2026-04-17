<?php

spl_autoload_register(function ($class) {

    // Ruta base absoluta del proyecto
    $base_dir = realpath(__DIR__ . '/../') . '/';

    // Solo cargar clases del namespace App
    $prefix = 'App\\';

    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    } else {
        die("❌ No se encontró la clase: " . $file);
    }
});