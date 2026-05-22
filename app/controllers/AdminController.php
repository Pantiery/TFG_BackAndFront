<?php

namespace App\Controllers;

use App\Models\PrendaModel;
use App\Core\Database;

class AdminController extends BaseController
{
    // FUNCION PARA VER EL PANEL DE ADMINISTRACIÓN

    public function index()
    {
        $this->checkAdmin();

        $this->view('admin/index');
    }

    // FUNCION PARA MOSTRAR LAS PRENDAS PENDIENTES DE REVISIÓN

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

    // FUNCION PARA REVISAR UNA PRENDA PENDIENTE

    public function revisarPrenda()
    {
        $this->checkAdmin();

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

    // FUNCION PARA APROBAR UNA PRENDA PENDIENTE

    public function aprobarPrenda()
    {
        $this->checkAdmin();

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

    // FUNCION PARA RECHAZAR UNA PRENDA PENDIENTE

    public function rechazarPrenda()
    {
        $this->checkAdmin();

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

    // FUNCION PARA GESTIONAR LAS VENTAS DEL SISTEMA

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

    // FUNCION PARA VER EL DETALLE DE UNA VENTA

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

    // FUNCION PARA MARCAR UNA VENTA COMO PAGADA

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

    // FUNCION PARA VER LAS ESTADÍSTICAS DEL SISTEMA

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

    // FUNCION PARA GESTIONAR LOS USUARIOS DEL SISTEMA

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
