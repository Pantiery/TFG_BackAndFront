<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\PrendaController;

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
$router->get('/admin/prendas/insertar', [AdminController::class, 'showInsertarPrenda']);
$router->post('/admin/prendas/insertar', [AdminController::class, 'insertarPrenda']);

// RUTA PARA VER MIS PRENDAS
$router->get('/prendas/misVentas', [PrendaController::class, 'misVentas']);
