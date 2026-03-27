<?php

namespace App\Controllers;

class AdminController extends BaseController
{

    public function index()
    {
        //PROTECCION DE RUTA SOLO PARA ADMIN
        $this->checkAdmin();

        require __DIR__ . '/../views/admin/index.php';
    }
    
}