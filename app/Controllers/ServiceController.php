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
        // Render the service view
        View::render('dashboard', [
            'title' => 'DashBoard',
            'user' => $_SESSION['user']
        ]);
    }
}
