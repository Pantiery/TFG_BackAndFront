<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\PrendaController;
use App\Controllers\CarritoController;

// RUTAS DE LA APLICACIÓN

// RUTA DE INICIO
$router->get('/', [HomeController::class, 'index']);

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

// RUTAS DE PRENDAS
$router->get('/prendas/solicitar', [PrendaController::class, 'create']);
$router->post('/prendas/solicitar', [PrendaController::class, 'store']);

// RUTAS DE INSERTAR PRENDAS
// $router->get('/admin/prendas/insertar', [AdminController::class, 'showInsertarPrenda']);
// $router->post('/admin/prendas/insertar', [AdminController::class, 'insertarPrenda']);

$router->get('/admin/prendas/insertar', [PrendaController::class, 'createAdmin']);
$router->post('/admin/prendas/insertar', [PrendaController::class, 'storeAdmin']);

// RUTA PARA VER MIS PRENDAS
$router->get('/prendas/misVentas', [PrendaController::class, 'misVentas']);

// RUTA PARA VER PRENDAS EN VENTA
$router->get('/prendas/catalogo', [PrendaController::class, 'catalogo']);

// RUTA PARA AÑADIR CARRITO
$router->post('/carrito/add', [CarritoController::class, 'add']);
$router->get('/carrito', [CarritoController::class, 'index']);

