<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

session_start();

$router = new Router();

require_once __DIR__ . '/../routes/web.php';

$router->resolve();