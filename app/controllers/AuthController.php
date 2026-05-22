<?php

namespace App\Controllers;

use App\Config\App;
use App\Controllers\BaseController;
use App\Services\AuthService;

class AuthController extends BaseController
{
    // REDIRIGIR A LOGIN SI YA ESTÁ AUTENTICADO

    public function showLogin()
    {
        if (isset($_SESSION['usuario'])) {
            header('Location: ' . App::url('/'));
            exit;
        }

        $this->view('auth/login');
    }

    // REDIRIGIR A REGISTRO SI YA ESTÁ AUTENTICADO

    public function showRegister()
    {
        if (isset($_SESSION['usuario'])) {
            header('Location: ' . App::url('/'));
            exit;
        }

        $this->view('auth/register');
    }

    // REGISTRAR NUEVO USUARIO

    public function register()
    {
        $service = new AuthService();

        try {
            $service->registrar($_POST);

            $_SESSION['mensaje_exito'] = 'Registro completado correctamente. Ya puedes iniciar sesión.';

            header('Location: ' . App::url('/login'));
            exit;
        } catch (\Exception $e) {
            $_SESSION['mensaje_error'] = $e->getMessage();
            header('Location: ' . App::url('/register'));
            exit;
        }
    }

    // FUNCION PARA INICIAR SESIÓN

    public function login()
    {
        $service = new AuthService();

        try {
            $usuario = $service->login($_POST);

            // Regenerar el ID de sesión para prevenir ataques de fijación de sesión

            session_regenerate_id(true);

            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'apellido1' => $usuario['apellido1'],
                'apellido2' => $usuario['apellido2'],
                'email' => $usuario['email'],
                'rol' => $usuario['rol'],
            ];

            // comprobar si tiene carrito, si no, crearlo

            $carritoService = new \App\Services\CarritoService();

            $carrito = $carritoService->getByUserId($usuario['id']);

            if (!$carrito) {
                $carritoService->create($usuario['id']);
            }

            header('Location: ' . App::url('/'));
            exit;
        } catch (\Exception $e) {
            $_SESSION['mensaje_error'] = $e->getMessage();
            header('Location: ' . App::url('/login'));
            exit;
        }
    }

    // FUNCIÓN PARA CERRAR SESIÓN

    public function logout()
    {
        $_SESSION = [];
        session_destroy();

        header('Location: ' . App::url('/'));
        exit;
    }

    // FUNCIÓN PARA MOSTRAR LA VISTA DE RECUPERAR CONTRASEÑA

    public function showRecuperar()
    {
        $this->view('auth/recuperar');
    }

    // FUNCIÓN PARA PROCESAR LA RECUPERACIÓN DE CONTRASEÑA
    
    public function recuperarPassword()
    {
        $_SESSION['mensaje_exito'] =
            'Si el correo existe en el sistema, se ha enviado un enlace de recuperación.';

        header('Location: ' . \App\Config\App::url('/login'));
        exit;
    }
}
