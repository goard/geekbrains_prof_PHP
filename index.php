<?php

include_once 'config/config.php';
require_once 'vendor/autoload.php';
// $ff = new \Lesson5\Core

$router = new \Lesson5\Core\Router();
// var_dump($router);

$router->add('', ['namespace' => 'User', 'controller' => 'User', 'action' => 'index']);
$router->add('{controller}/{action}', ['namespace' => 'User']);

if (!empty($_GET['path'])) {
  $router->dispatch($_GET['path']);
} else {
  // var_dump($_SERVER);
  $router->dispatch($_SERVER['QUERY_STRING']);
}