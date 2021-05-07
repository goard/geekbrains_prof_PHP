<?php

namespace app\src\core;

class Application
{
  public static $ROOT_DIR;
  public $router;
  public $request;
  public $response;
  public $db;
  public static $app;
  public $controller;
  public $session;
  public static $rootURL;
  public $user;
  public $userClass;

  public function __construct($rootPath, array $config, $root)
  {
    $this->userClass = $config['userClass'];
    self::$ROOT_DIR = $rootPath;
    self::$app = $this;
    self::$rootURL = $root;
    $this->request = new Request();
    $this->response = new Response();
    $this->session = new Session();
    $this->router = new Router($this->request, $this->response);
    $this->db = new Database($config['db']);

    $primaryValue = $this->session->get('user');
    if ($primaryValue) {
      $primaryKey = $this->userClass::primaryKey();
      $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
    } else {
      $this->user = null;
    }
  }

  public static function isGuest()
  {
    return !self::$app->user;
  }

  public function run()
  {
    echo $this->router->resolve();
  }

  public function getController(): Controller
  {
    return $this->controller;
  }

  public function setController(Controller $controller): void
  {
    $this->controller = $controller;
  }

  public function login(DBModel $user)
  {
    $this->user = $user;
    $primaryKey = $user->primaryKey();
    $primaryValue = $user->{$primaryKey};
    $this->session->set('user', $primaryValue);
    return true;
  }

  public function logout()
  {
    $this->user = null;
    $this->session->remove('user');
  }

}
