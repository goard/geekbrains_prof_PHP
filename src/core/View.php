<?php

namespace app\src\core;

use Twig\Loader\FilesystemLoader;

class View
{
  protected $data = [];
  protected $template;

  public function __construct($template, array $data = [])
  {
    $this->template = "user/$template.twig";
    $this->data = $data;
  }

  public function show()
  {
    try {
      $loader = new FilesystemLoader(Application::$ROOT_DIR . '/templates');
      $twig = new \Twig\Environment($loader, [
        'debug' => true
      ]);
      $twig->addExtension(new \Twig\Extension\DebugExtension());

      $template = $twig->load($this->template);
      $template->display($this->data);
    } catch (\Throwable $th) {
      throw $th;
    } catch (\Exception $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

  public function setData(array $data=[]): self
  {
    $this->data = $data;
    return $this;
  }

  public function __toString()
  {
    $this->show();
    return '';
  }
}