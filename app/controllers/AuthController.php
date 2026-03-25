<?php

namespace App\Controllers;

use PDO;

class AuthController
{
    //REDIRECCION A LOGIN
    public function showLogin()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
            exit;
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    //REDIRECCION A REGISTRO
    public function showRegister()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
            exit;
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    public function register()
    {
        $nombre = $_POST['nombre'] ?? '';
    }

    //FUNCION PARA HACER LOGIN
    public function login()
    {
        //TRAER CONEXION CREADA
        require __DIR__ . '/../../config/database.php';

        //RECOGO DATOS FORMULARIO
        $email = $_POST['email'];
        $password = $_POST['password'];

        //PREPARO CONSULTA
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //COMPROBACION USUARIO
        if ($usuario) {

            if ($password === $usuario['password']) {

                //COJO NOMBRE DE QUIEN HA HECHO LOGIN PARA LA SESION
                $_SESSION['user'] = $email;

                header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
                exit;

            } else {
                echo "Password incorrecto";
            }

        } else {
            echo "Usuario NO encontrado";
        }
    }

    public function logout()
    {
        session_destroy();

        header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
        exit;
    }

}