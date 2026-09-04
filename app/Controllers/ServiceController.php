<?php

namespace Controllers;

require_once __DIR__ . '/../Model/Service.php';

use Config\View;
use BD\Connect;
use Model\Service;
use PDO;

class ServiceController
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = (new Connect())->connect();
    }
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $services = (new Service($this->connection))->getAllServices();
        // var_dump($services); // Debugging line to check the contents of $services
        $pendingServices = array_filter($services, fn($service) => $service['status'] === 'Pendente');

        View::render('dashboard', [
            'title' => 'Dashboard',
            'user' => $_SESSION['user'],
            'services' => $services,
            'pendingServices' => $pendingServices
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
            'user' => $_SESSION['user'],

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


        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');

        if ($description === '' || $price === '') {
            View::render('service-create', [
                'title' => 'Cadastrar Novo Serviço',
                'error' => 'Preencha todos os campos.',
                'old' => [
                    'description' => $description,
                    'price' => $price
                ]
            ]);

            return;
        }

        if (!is_numeric($price) || (float) $price <= 0) {
            View::render('service-create', [
                'title' => 'Cadastrar Novo Serviço',
                'error' => 'Informe um preço válido.',
                'old' => [
                    'description' => $description,
                    'price' => $price
                ]
            ]);

            return;
        }

        $userId = $_SESSION['user']['id_user'];

        $service = new Service($this->connection);
        $commission = $this->calculateCommission((float) $price);
        $service->create($userId, $description, (float) $price, $commission);

        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }

    private function calculateCommission(float $price): float
    {
        if ($price > 10000) {
            return $price * 0.20;
        }

        if ($price > 1000) {
            return $price * 0.10;
        }

        return $price * 0.05;
    }
}
