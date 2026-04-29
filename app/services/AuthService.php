<?php

namespace App\Services;

use App\Core\Database;
use PDO;

class AuthService
{
    public function registrar($data)
    {
        $pdo = Database::getConnection();

        $nombre = $data['nombre'] ?? '';
        $apellido1 = $data['apellido1'] ?? '';
        $apellido2 = $data['apellido2'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

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

    public function login($data)
    {
        $pdo = Database::getConnection();

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute(['email' => $email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            throw new \Exception('Credenciales incorrectas');
        }

        return $usuario;
    }
}
