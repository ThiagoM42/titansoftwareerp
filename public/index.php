<?php
require_once __DIR__ . '/../BD/connect.php';
require_once __DIR__ . '/../app/Config/Router.php';
require_once __DIR__ . '/../app/Controllers/LoginController.php';

use BD\Connect;
use Config\Router;
use Controllers\LoginController;
// $teste = new Connect();
$router = new Router();


$router->get('/', [LoginController::class, 'index']);

$router->run();
// echo "Conexão realizada com sucesso!";
