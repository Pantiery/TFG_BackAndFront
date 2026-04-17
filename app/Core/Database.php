<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection === null) {

            //HOST
            // $host = 'localhost';
            //NOMBRE BASE DE DATOS
            // $db = 'uniformes_segunda_mano';
            //USER
            // $user = 'root';
            //PASSWORD VACIO
            $pass = '';
            //CHARSET (que es?)

            $host = 'sql8.freesqldatabase.com';
            $dbname = 'sql8823386'; // ← tu BD
            $user = 'sql8823386';
            $pass = 'gtqVCrJh67';
            $charset = 'utf8mb4';

            try {
                self::$connection = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8",
                    $user,
                    $pass
                );

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}

