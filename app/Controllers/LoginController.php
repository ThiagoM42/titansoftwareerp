<?php

namespace Controllers;

require_once __DIR__ . '/../Config/View.php';

use Config\View;
use Models\User;

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
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->authenticate(
            $email,
            $password
        );

        if (!$user) {
            echo "E-mail ou senha inválidos.";
            return;
        }

        session_start();

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ];

        var_dump($_SESSION['user']);
    }
}
