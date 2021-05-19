<?php

namespace app\src\models;

use app\src\core\UserModel;


class User extends UserModel
{
  public string $name;
  public string $login;
  public string $password;
  public string $confirmPassword;

  public function tableName(): string
  {
    return 'auth';
  }

  public function attributes(): array
  {
    return ['name', 'login', 'password'];
  }

  public function primaryKey(): string
  {
    return 'id';
  }

  public function save()
  {
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    return parent::save();
  }


  public function rules(): array
  {
    return [
      'name' => [self::RULE_REQUIRED],
      'login' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
      'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
    ];
  }

  public function getDisplayName(): string
  {
    return $this->name . ' ' . $this->login;
  }
}