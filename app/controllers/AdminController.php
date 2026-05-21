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

        // CAPTURAR BÚSQUEDA
        $busqueda = trim($_GET['buscar'] ?? '');

        // ENVIAR BÚSQUEDA AL MODELO
        $pendientes = $prendaModel->obtenerPendientes($pdo, $busqueda);

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

        $prenda = $prendaModel->obtenerPorId($id);

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

        $prendaModel->aprobar($id);

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

        $prendaModel->rechazar($id);

        $_SESSION['mensaje_exito'] = 'Prenda rechazada correctamente';

        header('Location: ' . \App\Config\App::url('/admin/prendas-pendientes'));
        exit;
    }

    // Gestión de ventas del sistema
    public function ventas()
    {
        $this->checkAdmin();

        $estado = $_GET['estado'] ?? null;
        $desde = $_GET['desde'] ?? null;
        $hasta = $_GET['hasta'] ?? null;
        $vendedor = trim($_GET['vendedor'] ?? '');

        $ventaService = new \App\Services\VentaService();

        $ventas = $ventaService->obtenerTodasLasVentas(
            $estado,
            $desde,
            $hasta,
            $vendedor
        );

        // Estadísticas

        $totalComisiones = 0;
        $totalVentas = 0;
        $totalPrendas = 0;
        $netoTotal = 0;

        foreach ($ventas as $venta) {

            $totalVentas += $venta['total'];

            foreach ($venta['prendas'] as $prenda) {

                $totalComisiones += $prenda['comision'];

                $totalPrendas++;
                $netoTotal += $prenda['importe_vendedor'];
            }
        }

        $totalPedidos = count($ventas);

        $this->view('admin/ventas', [
            'ventas' => $ventas,
            'totalComisiones' => $totalComisiones,
            'totalVentas' => $totalVentas,
            'totalPedidos' => $totalPedidos,
            'totalPrendas' => $totalPrendas,
            'netoTotal' => $netoTotal
        ]);
    }

    // Ver detalle de una venta
    public function detalleVenta()
    {
        $this->checkAdmin();

        $ventaId = $_GET['id'] ?? null;

        if (!$ventaId) {

            $_SESSION['mensaje_error'] = 'Venta inválida';

            header('Location: ' . \App\Config\App::url('/admin/ventas'));
            exit;
        }

        $ventaService = new \App\Services\VentaService();

        // Obtener detalle completo
        $detalle = $ventaService->obtenerDetalleVenta($ventaId);

        // Validar existencia
        if (!$detalle) {

            $_SESSION['mensaje_error'] = 'La venta no existe';

            header('Location: ' . \App\Config\App::url('/admin/ventas'));
            exit;
        }

        $this->view('admin/detalleVenta', [
            'detalle' => $detalle
        ]);
    }

    // Marcar una venta como pagada
    public function marcarPagada()
    {
        $this->checkAdmin();

        $ventaId = $_POST['venta_id'] ?? null;

        if (!$ventaId) {

            return $this->jsonResponse(
                false,
                'Venta inválida',
                '/admin/ventas'
            );
        }

        $ventaService = new \App\Services\VentaService();

        // Obtener venta
        $venta = $ventaService->obtenerVentaPorId($ventaId);

        // Validar existencia
        if (!$venta) {

            return $this->jsonResponse(
                false,
                'La venta no existe',
                '/admin/ventas'
            );
        }

        // Evitar doble pago
        if ($venta['estado_pago'] === 'pagado') {

            return $this->jsonResponse(
                false,
                'Esta venta ya está pagada',
                '/admin/ventas'
            );
        }

        // Marcar pagada
        $ventaService->marcarVentaPagada($ventaId);

        return $this->jsonResponse(
            true,
            'Pago marcado correctamente',
            '/admin/ventas',
            [
                'ventaId' => $ventaId
            ]
        );
    }

    // Estadísticas del sistema
    public function estadisticas()
    {
        $this->checkAdmin();

        $ventaService = new \App\Services\VentaService();

        $ventas = $ventaService->obtenerTodasLasVentas();

        $totalComisiones = 0;
        $totalVentas = 0;
        $totalPrendas = 0;
        $netoTotal = 0;

        foreach ($ventas as $venta) {

            $totalVentas += $venta['total'];

            foreach ($venta['prendas'] as $prenda) {

                $totalComisiones += $prenda['comision'];

                $totalPrendas++;

                $netoTotal += $prenda['importe_vendedor'];
            }
        }

        $totalPedidos = count($ventas);

        // MÉTRICAS SOSTENIBILIDAD

        $co2Ahorrado = $totalPrendas * 6;

        $aguaAhorrada = $totalPrendas * 2700;

        $ahorroFamilias = $totalPrendas * 20;

        $this->view('admin/estadisticas', [

            'totalVentas' => $totalVentas,
            'totalComisiones' => $totalComisiones,
            'totalPedidos' => $totalPedidos,
            'totalPrendas' => $totalPrendas,
            'netoTotal' => $netoTotal,
            'co2Ahorrado' => $co2Ahorrado,
            'aguaAhorrada' => $aguaAhorrada,
            'ahorroFamilias' => $ahorroFamilias

        ]);
    }

    // Gestión de usuarios
    public function usuarios()
    {
        $this->checkAdmin();

        $buscar = trim($_GET['buscar'] ?? '');

        $userModel = new \App\Models\UserModel();

        if (!empty($buscar)) {

            $usuarios = $userModel->buscarUsuarios($buscar);
        } else {

            $usuarios = $userModel->obtenerTodos();
        }

        $this->view('admin/usuarios', [
            'usuarios' => $usuarios
        ]);
    }
}
