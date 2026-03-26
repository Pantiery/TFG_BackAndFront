<?php

namespace App\Controllers;

use PDO;

class AuthController
{
    //REDIRECCION A LOGIN
    public function showLogin()
    {
        if (isset($_SESSION['usuario'])) {
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
            exit;
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    //REDIRECCION A REGISTRO
    public function showRegister()
    {
        if (isset($_SESSION['usuario'])) {
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
            exit;
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    //REGISTRO USUARIO
    public function register()
    {
        $nombre = $_POST['nombre'] ?? '';
        $apellido1 = $_POST['apellido1'] ?? '';
        $apellido2 = $_POST['apellido2'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$nombre || !$apellido1 || !$email || !$password) {
            $_SESSION['error-campos'] = "Todos los campos obligatorios deben ser completados";
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/register");
            exit;
        }

        require __DIR__ . '/../../config/database.php';

        //VERIFICO SI EXISTE EL EMAIL
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $resulset = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resulset) {
            $_SESSION['error-registro'] = "El email ya esta registrado";
            header("Location: /proyecto_TFG/TFG_BackAndFront/public/register");
            exit;
        }

        //CODIFICAMOS CONTRASEÑA
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //HACEMOS INSERT EN BD
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido1, apellido2, email, password) VALUES (:nombre, :apellido1, :apellido2, :email, :password)");

        $stmt->execute([
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2 ?? null,
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
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        //PREPARO CONSULTA
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //COMPROBACION USUARIO

        if ($usuario && password_verify($password, $usuario['password'])) {

            //COJO NOMBRE DE QUIEN HA HECHO LOGIN PARA LA SESION
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'apellido1' => $usuario['apellido1'],
                'apellido2' => $usuario['apellido2'],
                'email' => $usuario['email'],
                'rol' => $usuario['rol']
            ];

            if ($usuario['rol'] === 'user') {
                header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
                exit;
            } else if ($usuario['rol'] === 'admin') {
                header("Location: /proyecto_TFG/TFG_BackAndFront/public/admin");
                exit;
            }

        } else {

            $_SESSION['error'] = "Credenciales incorrectas";

            header("Location: /proyecto_TFG/TFG_BackAndFront/public/login");
            exit;
        }
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();

        header("Location: /proyecto_TFG/TFG_BackAndFront/public/");
        exit;
    }

}