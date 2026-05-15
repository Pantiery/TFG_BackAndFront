<?php

namespace App\Services;

use App\Core\Database;
use PDO;

class AuthService
{
    public function registrar($data)
    {
        $pdo = Database::getConnection();

        $nombre = htmlspecialchars(trim($data['nombre'] ?? ''));
        $apellido1 = htmlspecialchars(trim($data['apellido1'] ?? ''));
        $apellido2 = htmlspecialchars(trim($data['apellido2'] ?? ''));

        $email = filter_var(
            trim($data['email'] ?? ''),
            FILTER_SANITIZE_EMAIL
        );

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

        if (strlen($nombre) < 2 || strlen($apellido1) < 2) {
            throw new \Exception('El nombre y apellido deben tener al menos 2 caracteres');
        }

        if (
            strlen($nombre) > 50 ||
            strlen($apellido1) > 50 ||
            strlen($apellido2) > 50
        ) {
            throw new \Exception('Los nombres no pueden superar los 50 caracteres');
        }

        if (
            !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $nombre) ||
            !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $apellido1)
        ) {
            throw new \Exception('El nombre y apellido solo pueden contener letras');
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

        $email = filter_var(
            trim($data['email'] ?? ''),
            FILTER_SANITIZE_EMAIL
        );

        $password = trim($data['password'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('El email no es válido');
        }

        if (!$email || !$password) {
            throw new \Exception('Debes completar todos los campos');
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
