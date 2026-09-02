<?php
require_once __DIR__ . '/../BD/connect.php';
require_once __DIR__ . '/../app/Config/Router.php';
require_once __DIR__ . '/../app/Controllers/LoginController.php';
require_once __DIR__ . '/../app/Config/Config.php';
require_once __DIR__ . '/../app/Models/User.php';

use BD\Connect;
use Config\Router;
use Controllers\LoginController;
// $teste = new Connect();
$router = new Router();

$router->get('/', [LoginController::class, 'index']);
$router->post('/login', [LoginController::class, 'login']);

$router->run();
// echo "Conexão realizada com sucesso!";
