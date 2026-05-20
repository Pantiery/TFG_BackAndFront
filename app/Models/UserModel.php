<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class UserModel
{
    private $pdo;

    // Constructor para establecer conexión a la base de datos
    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    // Buscar por email
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM usuarios
        WHERE email = :email
    ");

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar por ID
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM usuarios
        WHERE id = :id
    ");

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear nuevo usuario
    public function create($data)
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO usuarios (
            nombre,
            apellido1,
            apellido2,
            email,
            password
        )
        VALUES (
            :nombre,
            :apellido1,
            :apellido2,
            :email,
            :password
        )
    ");

        $stmt->execute([
            'nombre' => $data['nombre'],
            'apellido1' => $data['apellido1'],
            'apellido2' => $data['apellido2'] ?? null,
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        return $this->pdo->lastInsertId();
    }


    // Obtener todos los usuarios
    public function obtenerTodos()
    {
        $stmt = $this->pdo->query("
        SELECT *
        FROM usuarios
        ORDER BY id DESC
    ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar usuarios por nombre, apellido o email
    public function buscarUsuarios($buscar)
    {
        $stmt = $this->pdo->prepare("
        SELECT *
        FROM usuarios
        WHERE nombre LIKE :buscar
        OR apellido1 LIKE :buscar
        OR email LIKE :buscar
        ORDER BY id DESC
    ");

        $stmt->execute([
            'buscar' => '%' . $buscar . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
