<?php

namespace app\src\controllers;

use app\src\core\Application;
use app\src\core\Controller;
use app\src\core\Request;
use app\src\core\Response;
use app\src\models\LoginForm;
use app\src\models\User;
use app\src\models\Orders;
use app\src\core\middlewares\AuthMiddleware;

class AuthController extends Controller
{
  public function __construct()
  {
    $this->registerMiddleware(new AuthMiddleware(['orders']));
  }
  public function login(Request $request, Response $response)
  {
    $loginForm = new LoginForm();
    if ($request->isPost()) {
      $loginForm->loadData($request->getBody());
      if ($loginForm->validate() && $loginForm->login()) {
        $response->redirect('/profphp/');
        return;
      }
    }
    $this->setLayout('auth');
    return $this->render('login', [
      'model' => $loginForm
    ]);
  }

  public function register(Request $request)
  {
    $errors = [];
    $user = new User();

    if ($request->isPost()) {
      $user->loadData($request->getBody());

      if ($user->validate() && $user->save()) {
        Application::$app->session->setFlash('success', 'Вы зарегистрировались');
        Application::$app->response->redirect('/profphp/');
        exit;
      }

      $this->setLayout('auth');
      return $this->render('register', [
        'model' => $user
      ]);
    }
    $this->setLayout('auth');
    return $this->render('register', [
      'model' => $user
    ]);
  }

  public function logout (Request $request, Response $response)
  {
    Application::$app->logout();
    $response->redirect('/profphp/');
  }

  public function orders (Request $request)
  {
    $orders = new Orders();
    if ($request->isPost()) {
      $orders->loadData($request->getBody());
      $orders->changeStatus($_POST['id']);
    }

    return $this->render('orders',[
      'model' => $orders
    ]);
  }
}
