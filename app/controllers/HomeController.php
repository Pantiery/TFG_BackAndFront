<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $user = $_SESSION['usuario'] ?? null;

        $this->view('prendas/home', [
            'user' => $user
        ]);
    }
}