<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    // RUTA DE INICIO
    public function index()
    {
        $user = $_SESSION['usuario'] ?? null;

        $this->view('prendas/home', [
            'user' => $user,
        ]);
    }

    // NUEVA RUTA DE CONTACTO
    public function contacto()
    {
        $this->view('layout/contacto');
    }

    // PROCESAR FORMULARIO DE CONTACTO
    public function enviarContacto()
    {
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $asunto = trim($_POST['asunto'] ?? '');
        $mensaje = trim($_POST['mensaje'] ?? '');

        // SIMULACIÓN DE ENVÍO

        $_SESSION['mensaje_exito'] = 'Consulta enviada correctamente. Nos pondremos en contacto contigo pronto.';

        header('Location: ' . \App\Config\App::url('/contacto'));
        exit;
    }
}
