<?php

namespace App\Services;

use App\Core\Database;
use PDO;

class AuthService
{
    public function registrar($data)
    {
        $pdo = Database::getConnection();

        $nombre = trim($data['nombre'] ?? '');
        $apellido1 = trim($data['apellido1'] ?? '');
        $apellido2 = trim($data['apellido2'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = trim($data['password'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('El email no es válido');
        }

        if (strlen($password) < 8) {
            throw new \Exception('La contraseña debe tener al menos 8 caracteres');
        }

        if (!$nombre || !$apellido1 || !$email || !$password) {
            throw new \Exception('Todos los campos obligatorios deben ser completados');
        }

        // Verificar email
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            throw new \Exception('El email ya está registrado');
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insert
        $stmt = $pdo->prepare('
            INSERT INTO usuarios (nombre, apellido1, apellido2, email, password) 
            VALUES (:nombre, :apellido1, :apellido2, :email, :password)
        ');

        $stmt->execute([
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2 ?: null,
            'email' => $email,
            'password' => $passwordHash,
        ]);
    }

    // Login
    public function login($data)
    {
        $pdo = Database::getConnection();

        $email = trim($data['email'] ?? '');
        $password = trim($data['password'] ?? '');

         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('El email no es válido');
        }

        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute(['email' => $email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            throw new \Exception('Credenciales incorrectas');
        }

        if ($usuario['activo'] == 0) {
            throw new \Exception("El usuario esta bloqueado, contacta con el administrador para más información");
        }

        return $usuario;
    }
}
