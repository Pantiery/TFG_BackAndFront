<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\UserController;
use App\Controllers\PrendaController;
use App\Controllers\CarritoController;
use App\Controllers\VentaController;


// Rutas públicas

// Página principal
$router->get('/', [HomeController::class, 'index']);

// Página de contacto
$router->get('/contacto', [HomeController::class, 'contacto']);

// Envío formulario de contacto
$router->post('/contacto', [HomeController::class, 'enviarContacto']);


// Rutas de autenticación

// Mostrar formulario login
$router->get('/login', [AuthController::class, 'showLogin']);

// Procesar login
$router->post('/login', [AuthController::class, 'login']);

// Cerrar sesión
$router->get('/logout', [AuthController::class, 'logout']);

// Mostrar formulario registro
$router->get('/register', [AuthController::class, 'showRegister']);

// Procesar registro usuario
$router->post('/register', [AuthController::class, 'register']);

// Mostrar recuperación contraseña
$router->get('/recuperar', [AuthController::class, 'showRecuperar']);

// Procesar recuperación contraseña
$router->post('/recuperar', [AuthController::class, 'recuperarPassword']);


// Rutas de administración

// Panel principal admin
$router->get('/admin', [AdminController::class, 'index']);

// Ver prendas pendientes de revisión
$router->get('/admin/prendas-pendientes', [AdminController::class, 'prendasPendientes']);

// Revisar detalle de una prenda
$router->get('/admin/prenda/revisar', [AdminController::class, 'revisarPrenda']);

// Aprobar prenda
$router->get('/admin/prenda/aprobar', [AdminController::class, 'aprobarPrenda']);

// Rechazar prenda
$router->get('/admin/prenda/rechazar', [AdminController::class, 'rechazarPrenda']);

// Ver todas las ventas del sistema
$router->get('/admin/ventas', [AdminController::class, 'ventas']);

// Ver detalle de una venta concreta
$router->get('/admin/ventas/detalle', [AdminController::class, 'detalleVenta']);

// Marcar venta como pagada
$router->get('/admin/ventas/pagar', [AdminController::class, 'marcarPagada']);

// Ver estadísticas generales
$router->get('/admin/estadisticas', [AdminController::class, 'estadisticas']);

// Mostrar formulario insertar prenda manualmente
$router->get('/admin/prendas/insertar', [PrendaController::class, 'createAdmin']);

// Guardar prenda creada por admin
$router->post('/admin/prendas/insertar', [PrendaController::class, 'storeAdmin']);


// Gestion de usuarios del sistema

// Ver listado usuarios
$router->get('/admin/usuarios', [UserController::class, 'index']);

// Bloquear usuario
$router->get('/admin/usuarios/bloquear', [UserController::class, 'bloquear']);

// Activar usuario bloqueado
$router->get('/admin/usuarios/activar', [UserController::class, 'activar']);

// Bloquear usuario o activar usuario bloqueado
$router->get('/admin/usuarios', [AdminController::class, 'usuarios']);


// Gestión de prendas del sistema

// Mostrar formulario para solicitar venta de prenda
$router->get('/prendas/solicitar', [PrendaController::class, 'create']);

// Guardar solicitud de venta
$router->post('/prendas/solicitar', [PrendaController::class, 'store']);

// Ver catálogo de prendas disponibles
$router->get('/prendas/catalogo', [PrendaController::class, 'catalogo']);

// Ver detalle dinámico/modal de una prenda
$router->get('/prendas/detalles', [PrendaController::class, 'detalles']);

// Ver prendas vendidas por el usuario
$router->get('/prendas/misVentas', [PrendaController::class, 'misVentas']);


// Carrito de compras

// Añadir prenda al carrito
$router->post('/carrito/add', [CarritoController::class, 'add']);

// Ver carrito
$router->get('/carrito', [CarritoController::class, 'index']);

// Eliminar prenda del carrito
$router->post('/carrito/remove', [CarritoController::class, 'remove']);

// Finalizar compra del carrito
$router->post('/carrito/checkout', [CarritoController::class, 'checkout']);


// Compras y ventas

// Comprar prenda directamente
$router->get('/venta/comprar', [VentaController::class, 'comprar']);

// Ver historial de compras del usuario
$router->get('/prendas/misCompras', [VentaController::class, 'misCompras']);

// Ver monedero virtual (ventas pendientes de pago)
$router->get('/monedero', [VentaController::class, 'monedero']);