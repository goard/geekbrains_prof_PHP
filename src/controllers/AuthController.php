<?php

namespace app\src\controllers;

use app\src\core\Application;
use app\src\core\Controller;
use app\src\core\Request;
use app\src\core\Response;
use app\src\model\LoginForm;
use app\src\model\UserModel;

class AuthController extends Controller
{
  public function login(Request $request, Response $response)
  {
    $loginForm = new LoginForm();
    if ($request->isPost()) {
      $loginForm->loadData($request->getBody());
      if ($loginForm->validate() && $loginForm->login()) {
        $response->redirect(Application::$rootURL . '/');
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
    $userModel = new UserModel();
    if ($request->isPost()) {
      $userModel->loadData($request->getBody());
      if ($userModel->validate() && $userModel->save()) {
        Application::$app->response->redirect(Application::$rootURL . '/');
      }
      $this->setLayout('auth');
      return $this->render('register', [
        'model' => $userModel
      ]);
    }
    $this->setLayout('auth');
    return $this->render('register', [
      'model' => $userModel
    ]);
  }

  public function logout(Request $request, Response $response)
  {
    Application::$app->logout();
    $response->redirect(Application::$rootURL . '/');
  }
}
