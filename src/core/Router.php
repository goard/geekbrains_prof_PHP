<?php

namespace app\src\core;

class Router
{
  public $request;
  public $response;
  protected $routes = [];

  public function __construct($request, $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  public function get($path, $callback)
  {
    $this->routes['get'][$path] = $callback;
  }

  public function post($path, $callback)
  {
    $this->routes['post'][$path] = $callback;
  }

  public function resolve()
  {

    $path = $this->request->getPath();
    $method = $this->request->method();
    $callback = $this->routes[$method][$path] ?? false;
    if ($callback === false) {
      Application::$app->controller = new Controller();
      $this->response->setStatusCode(404);
      return $this->renderView("_404");
    }
    if (is_string($callback)) {
      return $this->renderView($callback);
    }
    if (is_array($callback)) {
      Application::$app->controller = new $callback[0]();
      $callback[0] = Application::$app->controller;
    }
    return call_user_func($callback, $this->request, $this->response);
  }

  public function renderView($view, $params = [])
  {
    $layoutContent = $this->layoutContent();
    $viewContent = $this->renderOnlyView($view, $params);
    return str_replace('{{content}}', $viewContent, $layoutContent);
  }

  protected function layoutContent()
  {
    $layout = Application::$app->controller->layout;
    ob_start();
    include_once Application::$ROOT_DIR . "/templates/layouts/$layout.php";
    return ob_get_clean();
  }

  protected function renderOnlyView($view, $params)
  {
    ob_start();
    echo new View($view, $params);
    return ob_get_clean();
  }
}
