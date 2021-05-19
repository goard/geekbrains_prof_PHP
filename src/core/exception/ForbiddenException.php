<?php

namespace app\src\core\exception;
use Exception;

class ForbiddenException extends Exception
{
  protected $message = 'Доступ запрещён';
  protected $code = 403;
}