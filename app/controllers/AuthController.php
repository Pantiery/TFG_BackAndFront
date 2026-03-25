<?php

class AuthController
{
    //REDIRECCION A LOGIN
    public function showLogin()
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    //REDIRECCION A REGISTRO
    public function showRegister()
    {
        require __DIR__ . '/../views/auth/register.php';
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

}