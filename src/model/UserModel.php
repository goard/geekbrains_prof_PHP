<?php

namespace app\src\model;

use app\src\core\DBModel;

class UserModel extends DBModel
{
  public $name = '';
  public $login = '';
  public $password = '';

  public function rules(): array
  {
    return [
      'name' => [self::RULE_REQUIRED],
      'login' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
    ];
  }

  public function tableName(): string
  {
    return 'auth';
  }

  public function primaryKey(): string
  {
    return 'id';
  }

  public function attributes(): array
  {
    return ['name', 'login', 'password'];
  }

  public function save()
  {
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    return parent::save();
  }

  public function getDisplayName(): string
  {
    return $this->name. ' ' . $this->login;
  }
}
