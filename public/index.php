<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$url = $_SERVER['REQUEST_URI'];

if (strpos($url, "/login") !== false) {
    require '../app/controllers/AuthController.php';

    $controller = new AuthController();
    $controller->login();
    exit;
}

// fallback
echo json_encode([
    "error" => "Ruta no encontrada",
    "url" => $url
]);