<?php

namespace Controllers;

use Config\View;
use BD\Connect;
use Model\User;

class UserController
{
    public function create(): void
    {
        View::render('register', [
            'title' => 'Cadastrar usuário'
        ]);
    }

    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (
            $name === '' ||
            $email === '' ||
            $password === '' ||
            $confirmPassword === ''
        ) {
            View::render('register', [
                'title' => 'Cadastrar usuário',
                'error' => 'Preencha todos os campos.',
                'old' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);

            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            View::render('register', [
                'title' => 'Cadastrar usuário',
                'error' => 'Informe um e-mail válido.',
                'old' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);

            return;
        }

        if ($password !== $confirmPassword) {
            View::render('register', [
                'title' => 'Cadastrar usuário',
                'error' => 'As senhas não conferem.',
                'old' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);

            return;
        }

        $pdo = (new Connect())->connect();

        $user = new User($pdo);

        if ($user->findByEmail($email)) {
            View::render('register', [
                'title' => 'Cadastrar usuário',
                'error' => 'Este e-mail já está cadastrado.'
            ]);

            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $user->create($name, $email, $passwordHash);

        header('Location: ' . BASE_URL . '/');
        exit;
    }
}
