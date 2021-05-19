<?php

namespace app\src\models;

use app\src\core\Application;
use app\src\core\Model;

class LoginForm extends Model
{
  public string $login = '';
  public string $password = '';

  public function rules(): array
  {
    return [
      'login' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED]
    ];
  }

  public function login()
  {
    $user = User::findOne(['login' => $this->login]);
    if (!$user) {
      $this->addError('login', 'Пользователь не существует');
      return false;
    }
    if (!password_verify($this->password, $user->password)) {
      $this->addError('password', 'Пароль неверно');
      return false;
    }

    return Application::$app->login($user);
  }
}