<?php

class AuthController
{
    //REDIRECCION A LOGIN
    public function showLogin()
    {
        require_once __DIR__. '/../views/auth/login.php';
    }

    //HACER CONSULTA PARA REALIZAR LOGIN
    public function login()
    {
        //TRAER CONEXION CREADA
        require __DIR__ . '/../../config/database.php';

        //RECOGO DATOS FORMULARIO
        $email = $_POST['email'];
        $password = $_POST['password'];

        //PREPARO CONSULTA
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email'=>$email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //COMPROBACION USUARIO
        if ($usuario) {
            
            if ($password === $usuario['password']) {
                echo "Login realizado con éxito";
            }else {
                echo "Password incorrecto";
            }
        
        }else {
            echo "Usuario NO encontrado";
        }
    }

}