<?php

namespace App\Config;

class App
{
    /**
    * Obtiene la URL base dinámicamente sin hardcodear rutas
    * Funciona en cualquier servidor ( local, producción, etc. )
    */
    public static function baseUrl()
    {
        // Obtener el protocolo ( http o https )
        $protocol = (!empty($_SERVER[ 'HTTPS' ]) && $_SERVER[ 'HTTPS' ] !== 'off')
        ? 'https://'
        : 'http://';

        // Obtener el host ( dominio o localhost )
        $host = $_SERVER[ 'HTTP_HOST' ];

        // Obtener la ruta hasta /public ( sin el script actual )
        // Ejemplo: /proyecto_TFG/TFG_BackAndFront/public
        $baseDir = dirname($_SERVER[ 'SCRIPT_NAME' ]);

        // Si estamos en /public/index.php, dirname retorna /public
        // Si estamos en un subdirectorio, se ajusta automáticamente
        $baseUrl = rtrim($baseDir, '/');

        return $protocol . $host . $baseUrl;
    }

    /**
    * Método auxiliar para generar URLs completas
    * Uso: App::url( '/prendas/catalogo' )
    */
    public static function url($path = '')
    {
        return self::baseUrl() . '/' . ltrim($path, '/');
    }
}
