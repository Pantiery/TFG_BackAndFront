<?php

namespace App\Controllers;

use App\Models\PrendaModel;
use App\Core\Database;

class AdminController extends BaseController
{
    // función para mostrar el dashboard del admin
    public function index()
    {
        $this->checkAdmin();

        $this->view('admin/index');
    }

    // función para mostrar las prendas pendientes de revisión
    public function prendasPendientes()
    {
        $this->checkAdmin();

        $pdo = Database::getConnection();

        $prendaModel = new PrendaModel();

        $pendientes = $prendaModel->obtenerPendientes($pdo);

        $this->view('admin/prendasPendientes', [
            'pendientes' => $pendientes
        ]);
    }

    // función para revisar una prenda pendiente
    public function revisarPrenda()
    {
        $this->checkAdmin();

        $pdo = Database::getConnection();

        $id = $_GET['id'] ?? null;

        if (!$id) {

            $_SESSION['mensaje_error'] = 'ID inválido';

            header('Location: ' . \App\Config\App::url('/admin/prendas-pendientes'));
            exit;
        }

        $prendaModel = new PrendaModel();

        $prenda = $prendaModel->obtenerPorId($pdo, $id);

        // Si la prenda no existe o no está pendiente, mostrar error
        if (!$prenda) {
            $_SESSION['mensaje_error'] = 'Prenda no encontrada';

            header('Location: ' . \App\Config\App::url('/admin/prendas-pendientes'));
            exit;
        }

        // Verificar que la prenda esté pendiente antes de mostrar la revisión
        if ($prenda['estado_publicacion'] !== 'pendiente') {

            $_SESSION['mensaje_error'] = 'Esta prenda ya fue revisada';

            header('Location: ' . \App\Config\App::url('/admin/prendas-pendientes'));
            exit;
        }

        $this->view('admin/revisarPrenda', [
            'prenda' => $prenda
        ]);
    }

    // función para aprobar una prenda pendiente
    public function aprobarPrenda()
    {
        $this->checkAdmin();

        $pdo = Database::getConnection();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['mensaje_error'] = 'ID inválido';

            header('Location: ' . \App\Config\App::url('/admin/prendas-pendientes'));
            exit;
        }

        $prendaModel = new PrendaModel();

        $prendaModel->aprobar($pdo, $id);

        $_SESSION['mensaje_exito'] = 'Prenda aprobada correctamente';

        header('Location: ' . \App\Config\App::url('/admin/prendas-pendientes'));
        exit;
    }

    // función para rechazar una prenda pendiente
    public function rechazarPrenda()
    {
        $this->checkAdmin();

        $pdo = Database::getConnection();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['mensaje_error'] = 'ID inválido';

            header('Location: ' . \App\Config\App::url('/admin/prendas-pendientes'));
            exit;
        }

        $prendaModel = new PrendaModel();

        $prendaModel->rechazar($pdo, $id);

        $_SESSION['mensaje_exito'] = 'Prenda rechazada correctamente';

        header('Location: ' . \App\Config\App::url('/admin/prendas-pendientes'));
        exit;
    }
}
