<?php

namespace app\src\model;

use app\src\core\Application;
use app\src\core\Model;

class LoginForm extends Model
{
  public $login = '';
  public $password = '';

  public function rules(): array
  {
    return [
      'login' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED]
    ];
  }

  public function login()
  {
    $user = UserModel::findOne(['login' => $this->login]);
    if (!$user) {
      $this->addError('login', 'Нет логина в базе данных');
      return false;
    }
    if (!password_verify($this->password, $user->password)) {
      $this->addError('password', 'Неверный пароль');
      return false;
    }

    return Application::$app->login($user);
  }
}