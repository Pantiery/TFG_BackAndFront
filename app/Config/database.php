<?php

//HOST
// $host = 'localhost';
//NOMBRE BASE DE DATOS
// $db = 'uniformes_segunda_mano';
//USER
// $user = 'root';
//PASSWORD VACIO
$pass = '';
//CHARSET (que es?)
$charset = 'utf8mb4';

//HOST REMOTO
$host = 'sql8.freesqldatabase.com';
$db = 'sql8823386';
$user = 'sql8823386';
$pass = 'gtqVCrJh67';




try {
    //CREACION DE CONEXION PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);

    //CONTROL DE ERRORES
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die ("Error en la conexión: " . $e->getMessage());
}

