<?php

//HOST
$host = 'localhost';
//NOMBRE BASE DE DATOS
$db = 'uniformes_segunda_mano';
//USER
$user = 'root';
//PASSWORD VACIO
$pass = '';
//CHARSET (que es?)
$charset = 'utf8mb4';

try {
    //CREACION DE CONEXION PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);

    //CONTROL DE ERRORES
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die ("Error en la conexión: " . $e->getMessage());
}

