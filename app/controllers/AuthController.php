<?php

namespace App\Controllers;

use App\Config\App;
use App\Controllers\BaseController;
use App\Services\AuthService;

class AuthController extends BaseController
{
    // REDIRECCION A LOGIN

    public function showLogin()
    {
        if (isset($_SESSION[ 'usuario' ])) {
            header('Location: ' . App::url('/'));
            exit;
        }

        $this->view('auth/login');
    }

    // REDIRECCION A REGISTRO

    public function showRegister()
    {
        if (isset($_SESSION[ 'usuario' ])) {
            header('Location: ' . App::url('/'));
            exit;
        }

        $this->view('auth/register');
    }

    // REGISTRO USUARIO

    public function register()
    {
        $service = new AuthService();

        try {
            $service->registrar($_POST);

            header('Location: ' . App::url('/login'));
            exit;
        } catch (\Exception $e) {
            $_SESSION[ 'error_campos' ] = $e->getMessage();
            header('Location: ' . App::url('/register'));
            exit;
        }
    }

    // FUNCION PARA HACER LOGIN

    public function login()
    {
        $service = new AuthService();

        try {
            $usuario = $service->login($_POST);

            // Regenerar el ID de sesión para prevenir ataques de fijación de sesión
            session_regenerate_id(true);

            $_SESSION[ 'usuario' ] = [
                'id' => $usuario[ 'id' ],
                'nombre' => $usuario[ 'nombre' ],
                'apellido1' => $usuario[ 'apellido1' ],
                'apellido2' => $usuario[ 'apellido2' ],
                'email' => $usuario[ 'email' ],
                'rol' => $usuario[ 'rol' ],
            ];

            // comprobar si tiene carrito, si no, crearlo
            $carritoService = new \App\Services\CarritoService();

            $carrito = $carritoService->getByUserId($usuario[ 'id' ]);

            if (!$carrito) {
                $carritoService->create($usuario[ 'id' ]);
            }

            if ($usuario[ 'rol' ] === 'user') {
                header('Location: ' . App::url('/'));
            } else {
                header('Location: ' . App::url('/admin'));
            }

            exit;
        } catch (\Exception $e) {
            $_SESSION[ 'error_credenciales' ] = $e->getMessage();
            header('Location: ' . App::url('/login'));
            exit;
        }
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();

        header('Location: ' . App::url('/'));
        exit;
    }
}
