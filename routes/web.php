<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\UserController;
use App\Controllers\PrendaController;
use App\Controllers\CarritoController;
use App\Controllers\VentaController;

// RUTAS DE LA APLICACIÓN

// RUTA DE INICIO
$router->get('/', [HomeController::class, 'index']);

// RUTA CONTACTO
$router->get('/contacto', [HomeController::class, 'contacto']);
$router->post('/contacto', [HomeController::class, 'enviarContacto']);

// RUTAS DE AUTENTICACIÓN
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

// RUTA PARA INICIAR SESIÓN
$router->get('/logout', [AuthController::class, 'logout']);

// RUTAS DE REGISTRO
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

// RUTA DE ADMIN
$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/prendas-pendientes', [AdminController::class, 'prendasPendientes']);
$router->get('/admin/prenda/revisar', [AdminController::class, 'revisarPrenda']);
$router->get('/admin/prenda/aprobar', [AdminController::class, 'aprobarPrenda']);
$router->get('/admin/prenda/rechazar', [AdminController::class, 'rechazarPrenda']);
$router->get('/admin/ventas', [AdminController::class, 'ventas']);

// NUEVA RUTA DETALLE VENTA
$router->get('/admin/ventas/detalle', [AdminController::class, 'detalleVenta']);

$router->get('/admin/estadisticas', [AdminController::class, 'estadisticas']);
$router->get('/admin/ventas/pagar', [AdminController::class, 'marcarPagada']);

// RUTAS DE PRENDAS
$router->get('/prendas/solicitar', [PrendaController::class, 'create']);
$router->post('/prendas/solicitar', [PrendaController::class, 'store']);

// RUTAS DE INSERTAR PRENDAS
$router->get('/admin/prendas/insertar', [PrendaController::class, 'createAdmin']);
$router->post('/admin/prendas/insertar', [PrendaController::class, 'storeAdmin']);

// RUTA PARA VER MIS PRENDAS
$router->get('/prendas/misVentas', [PrendaController::class, 'misVentas']);

// RUTA PARA VER PRENDAS EN VENTA
$router->get('/prendas/catalogo', [PrendaController::class, 'catalogo']);

// RUTA PARA VER MIS COMPRAS REALIZADAS
$router->get('/prendas/misCompras', [VentaController::class, 'misCompras']);

// RUTA PARA AÑADIR CARRITO
$router->post('/carrito/add', [CarritoController::class, 'add']);
$router->get('/carrito', [CarritoController::class, 'index']);

// RUTA PARA ELIMINAR DEL CARRITO
$router->post('/carrito/remove', [CarritoController::class, 'remove']);

// RUTA PARA FINALIZAR COMPRA
$router->post('/carrito/checkout', [CarritoController::class, 'checkout']);

// RUTA PARA VER DETALLES DE PRENDA
$router->get('/prendas/detalles', [PrendaController::class, 'detalles']);

// RUTA PARA COMPRAR
// $router->post('/venta/comprar', [VentaController::class, 'comprar']);

$router->get('/venta/comprar', [VentaController::class, 'comprar']);
$router->get('/venta/testDetalle', [VentaController::class, 'testDetalle']);

// RUTA PARA VER MIS VENTAS
$router->get('/monedero', [VentaController::class, 'monedero']);

// RUTA PARA VER USUARIOS (ADMIN)
$router->get('/admin/usuarios', [UserController::class, 'index']);

// RUTAS PARA BLOQUEAR/ACTIVAR USUARIOS (ADMIN)
$router->get('/admin/usuarios/bloquear', [UserController::class, 'bloquear']);
$router->get('/admin/usuarios/activar', [UserController::class, 'activar']);

// RUTAS PARA RECUPERAR CONTRASEÑA
$router->get('/recuperar', [AuthController::class, 'showRecuperar']);
$router->post('/recuperar', [AuthController::class, 'recuperarPassword']);
