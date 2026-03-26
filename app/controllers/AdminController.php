<?php

namespace App\Controllers;

class AdminController extends BaseController
{

    public function index()
    {
        $this->checkAdmin();

        require __DIR__ . '/../views/admin/index.php';
    }
    
}