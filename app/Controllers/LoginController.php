<?php

namespace Controllers;

require_once __DIR__ . '/../Config/View.php';

use Config\View;

class LoginController
{
    public function index()
    {

        View::render('login', [
            'title' => 'Login',
        ]);
    }


    public function login()
    {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        echo "Tentando autenticar: {$email}";
    }
}
