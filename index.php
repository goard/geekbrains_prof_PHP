<?php

use app\src\controllers\AuthController;
use app\src\controllers\SiteController;
use app\src\core\Application;
use app\src\model\UserModel;

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
  'userClass' => UserModel::class,
  "db" => [
    'dsn' => $_ENV['DB_DSN'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
  ]
];

$root = '/profphp';

$app = new Application(__DIR__, $config, $root);

$app->router->get("$root/", [SiteController::class, 'home']);
$app->router->get("$root/contact", [SiteController::class, 'contact']);
$app->router->post("$root/contact", [SiteController::class, 'handleContact']);

$app->router->get("$root/login", [AuthController::class, 'login']);
$app->router->post("$root/login", [AuthController::class, 'login']);
$app->router->get("$root/register", [AuthController::class, 'register']);
$app->router->post("$root/register", [AuthController::class, 'register']);
$app->router->get("$root/logout", [AuthController::class, 'logout']);

$app->run();
