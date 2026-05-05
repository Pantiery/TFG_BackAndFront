<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    // LISTADO DE USUARIOS PARA ADMIN
    public function index()
    {
        $this->checkLogin();

        // SOLO ADMIN
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header('Location: ' . \App\Config\App::baseUrl());
            exit;
        }

        // 🔗 CONEXIÓN (TU FORMA CORRECTA)
        $pdo = \App\Core\Database::getConnection();

        // CONSULTA
        $stmt = $pdo->prepare("
            SELECT id, nombre, apellido1, apellido2, email, rol, activo 
            FROM usuarios
        ");
        $stmt->execute();

        $usuarios = $stmt->fetchAll();

        // VISTA
        $this->view('admin/usuarios', [
            'usuarios' => $usuarios
        ]);
    }

    // BLOQUEAR USUARIO
    public function bloquear()
    {
        $this->checkAdmin();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . \App\Config\App::url('/admin/usuarios'));
            exit;
        }

        $pdo = \App\Core\Database::getConnection();

        // VALIDAR QUE EL USUARIO EXISTE
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        if (!$user) {
            header('Location: ' . \App\Config\App::url('/admin/usuarios'));
            exit;
        }

        $stmt = $pdo->prepare("UPDATE usuarios SET activo = 0 WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['mensaje'] = 'Usuario bloqueado correctamente';

        header('Location: ' . \App\Config\App::url('/admin/usuarios'));
        exit;
    }

    // ACTIVAR USUARIO
    public function activar()
    {
        $this->checkAdmin();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . \App\Config\App::url('/admin/usuarios'));
            exit;
        }

        $pdo = \App\Core\Database::getConnection();

        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        if (!$user) {
            header('Location: ' . \App\Config\App::url('/admin/usuarios'));
            exit;
        }

        $stmt = $pdo->prepare("UPDATE usuarios SET activo = 1 WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['mensaje'] = 'Usuario activado correctamente';

        header('Location: ' . \App\Config\App::url('/admin/usuarios'));
        exit;
    }
}
