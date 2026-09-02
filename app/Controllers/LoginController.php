<?php

namespace Controllers;

require_once __DIR__ . '/../Config/View.php';

use Config\View;

class LoginController
{
    public function index(): void
    {

        View::render('login', [
            'title' => 'Login',
        ]);
    }


    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        echo "Tentando autenticar: {$email}";
    }
}
