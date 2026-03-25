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
        $apellido1 = $_POST['apellido1'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$nombre || !$apellido1 || !$email || !$password) {
            echo "Faltan datos";
            return;
        }

        require __DIR__ . '/../../config/database.php';

        //VERIFICO SI EXISTE EL EMAIL
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $resulset = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resulset) {
            echo "El email ya esta registrado";
            return;
        }

        //CODIFICAMOS CONTRASEÑA
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //HACEMOS INSERT EN BD
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido1, email, password) VALUES (:nombre, :apellido1, :email, :password)");

        $stmt->execute([
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'email' => $email,
            'password' => $passwordHash
        ]);

        header("Location: /proyecto_TFG/TFG_BackAndFront/public/login");
        exit;

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

            if (password_verify($password, $usuario['password'])) 
                {

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