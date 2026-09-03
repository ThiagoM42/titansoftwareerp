<?php
require_once __DIR__ . '/../BD/connect.php';
require_once __DIR__ . '/../app/Config/Router.php';
require_once __DIR__ . '/../app/Controllers/LoginController.php';
require_once __DIR__ . '/../app/Config/Config.php';
require_once __DIR__ . '/../app/Model/User.php';
require_once __DIR__ . '/../app/Controllers/UserController.php';
require_once __DIR__ . '/../app/Controllers/ServiceController.php';


use Config\Router;
use Controllers\LoginController;
use Controllers\UserController;
use Controllers\ServiceController;

// $teste = new Connect();
$router = new Router();

$router->get('/', [LoginController::class, 'index']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/cadastro', [UserController::class, 'create']);
$router->post('/cadastro', [UserController::class, 'store']);
$router->get('/dashboard', [ServiceController::class, 'index']);

$router->run();
// echo "Conexão realizada com sucesso!";
