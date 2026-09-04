<?php

namespace Controllers;

require_once __DIR__ . '/../Config/View.php';

use Config\View;
use Model\User;
use BD\Connect;

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

        $pdo = (new Connect())->connect();
        $userModel = new User($pdo);

        $user = $userModel->authenticate(
            $email,
            $password
        );

        if (!$user) {
            View::render('login', [
                'title' => 'Login',
                'error' => 'E-mail ou senha inválidos.',
                'old' => [
                    'email' => $email
                ]
            ]);
            return;
        }

        session_start();

        $_SESSION['user'] = [
            'id_user' => $user['id_user'],
            'name' => $user['name'],
            'email' => $user['email']
        ];

        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
}
