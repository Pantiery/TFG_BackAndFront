<?php

namespace App\Controllers;

class AuthController
{
    public function login()
    {
        require __DIR__ . '/../views/auth/login.php';
    }

   public function doLogin()
{
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email === "test@test.com" && $password === "1234") {

        $_SESSION['user'] = $email;

        header("Location: /proyecto_TFG/back_end/TFG_BackEnd/public/");
        exit;

    } else {
        echo "Login incorrecto";
    }
}
}