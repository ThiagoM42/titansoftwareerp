<?php

namespace Controllers;

use Config\View;
use BD\Connect;
use Model\User;

class UserController
{
    // Renderiza a página de cadastro de usuário
    public function create(): void
    {
        View::render('register', [
            'title' => 'Cadastrar usuário'
        ]);
    }
    // Cadastro do usuário
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
                'error' => 'Este e-mail já está cadastrado.',
                'old' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);

            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            // retorna o ID do usuário recém-criado
            $id_user = $user->create($name, $email, $passwordHash);
        } catch (\Exception $e) {
            // Se o ID do usuário não for retornado, significa que houve um erro ao cadastrar o usuário
            View::render('register', [
                'title' => 'Cadastrar usuário',
                'error' => 'Erro ao cadastrar usuário. Tente novamente.',
                'old' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);

            return;
        }


        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Armazena os dados do usuário na sessão e redireciona para o dashboard
        $_SESSION['user'] = [
            'id_user'    => $id_user,
            'name'  => $name,
            'email' => $email,
        ];

        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
}
