<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    // FUNCION PARA MOSTRAR EL PANEL DE ADMINISTRACION
    public function index()
    {
        $this->checkAdmin();

        $this->view('admin/index');
    }
}
