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
use app\src\models\Product;
use ErrorException;
use Exception;
use Prophecy\Doubler\ClassPatch\ThrowablePatch;

class AuthController extends Controller
{
  public function __construct()
  {
    $this->registerMiddleware(new AuthMiddleware(['orders', 'product']));
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

  public function logout(Request $request, Response $response)
  {
    Application::$app->logout();
    $response->redirect('/profphp/');
  }

  public function orders(Request $request)
  {
    $orders = new Orders();
    if ($request->isPost()) {
      $orders->loadData($request->getBody());
      $orders->changeStatus($_POST['id']);
    }

    return $this->render('orders', [
      'model' => $orders
    ]);
  }

  public function product(Request $request)
  {
    try {
      $product = new Product();
      $switch = false;
      if ($request->isGet()) {
        $arrBody = $request->getBody();
        foreach ($arrBody as $key => $value) {
          if ($key === 'id') {
            $switch = true;
          }
        }
        if (!$switch) {
          throw new ErrorException('Нет данных', 440);
        }
        $product->loadData($request->getBody());
        $productClass = $product->productShow();
      }

      return $this->render('product', [
        'model' => $productClass
      ]);
    } catch (\ErrorException $e) {
      return $e;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
