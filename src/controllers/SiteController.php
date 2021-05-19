<?php

namespace app\src\controllers;

use app\src\core\Controller;
use app\src\core\Request;

class SiteController extends Controller
{
  public function home()
  {
    $params = [
      'name' => "Hi Ayur"
    ];
    return $this->render('home', $params);
  }

  public function contact()
  {
    return $this->render('contact');
  }

  public function handleContact(Request $request)
  {
    $body = $request->getBody();
    echo '<pre>';
    var_dump($request->method());
    echo '</pre>';
    exit;
    return 'Handling submitted data';
  }
}