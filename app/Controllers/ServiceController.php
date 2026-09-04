<?php

namespace Controllers;

use Config\View;

class ServiceController
{

    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        View::render('dashboard', [
            'title' => 'Dashboard',
            'user' => $_SESSION['user']
        ]);
    }

    public function create(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        View::render('service-create', [
            'title' => 'Cadastrar Serviço',
            'user' => $_SESSION['user']
        ]);
    }

    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }


        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
}
