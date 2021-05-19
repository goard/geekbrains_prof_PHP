<?php

namespace app\src\core\exception;

class NotFoundException extends \Exception
{
  protected $code = 404;
  protected $message = "Страница не найдена";
}