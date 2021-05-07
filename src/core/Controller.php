<?php

namespace app\src\core;

use app\src\core\Application;

class Controller
{
  public $layout = 'main';

  public function setLayout($layout)
  {
    $this->layout = $layout;
  }

  public function render($view, $params = [])
  {
    return Application::$app->router->renderView($view, $params);
  }
}
