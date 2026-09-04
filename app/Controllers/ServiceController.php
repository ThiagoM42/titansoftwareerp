<?php

namespace Controllers;

require_once __DIR__ . '/../Model/Service.php';
require_once __DIR__ . '/../Services/EmailService.php';

use Config\View;
use BD\Connect;
use Model\User;
use Model\Service;
use PDO;
use Services\EmailService;

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

        $id_user = $_SESSION['user']['id_user'];
        // Recebe os filtros de pesquisa do formulário
        $name = trim($_GET['name'] ?? '');
        $employeeId = $_GET['employee_id'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';

        $services = (new Service($this->connection))->getAllServices($name, $employeeId, $startDate, $endDate);
        // funções auxiliares para calcular a comissão total e filtrar os serviços pendentes para evitar conexões desnecessárias com o banco de dados
        // slice para pegar os últimos 5 serviços cadastrados
        $lastServices = array_slice($services, 0, 5);
        $pendingServices = array_filter($lastServices, fn($lastService) => $lastService['status'] === 'Pendente');

        // calcula a comissão total dos serviços do usuário logado diretamente do banco de dados, pois o filtro recalculava a comissão só com os elementos da pesquisa.
        $comissionTotal = (new Service($this->connection))->getComissionByUserId($id_user);

        $employees = (new User($this->connection))->getAllEmployees();

        View::render('dashboard', [
            'title' => 'Dashboard',
            'user' => $_SESSION['user'],
            'services' => $services,
            'pendingServices' => $pendingServices,
            'comissionTotal' => $comissionTotal,
            'employees' => $employees
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

    public function resolve(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        header('Content-Type: application/json; charset=utf-8');

        $serviceId = $_POST['serviceId'] ?? null;

        if ($serviceId === null) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
        try {
            $service = new Service($this->connection);
            $service->resolveService((int)$serviceId);
        } catch (\Exception $e) {
            // Retorna uma resposta JSON com sucesso falso e a mensagem de erro
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao resolver o serviço: ' . $e->getMessage()
            ]);
            exit;
        }

        // Enviado o e-mail de notificação para o usuário logado
        $emailService = new EmailService();
        // Não implementado pois localmente era necessário configurar um servidor SMTP para enviar e-mails, o que não foi feito.
        // $emailSent = $emailService->sendServiceResolved(
        //     $_SESSION['user']['email'],
        //     $_SESSION['user']['name'],
        //     (int)$serviceId
        // );
        $emailSent = true; // Simulação de envio de e-mail bem-sucedido
        // se tudo correr bem, retorna uma resposta JSON com sucesso verdadeiro e a URL de redirecionamento
        echo json_encode([
            'success' => true,
            'message' => $emailSent
                ? 'Serviço resolvido e e-mail enviado com sucesso.'
                : 'Serviço resolvido, mas falha ao enviar o e-mail.',
            'redirect' => BASE_URL . '/dashboard'
        ]);


        // header('Location: ' . BASE_URL . '/dashboard');
        // exit;
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
