<?php

$router->get('/', function() {
    require_once __DIR__ . '/../app/views/prendas/home.php';
});

use App\Controllers\AuthController;

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'doLogin']);