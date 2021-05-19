<?php

namespace app\src\core;

abstract class UserModel extends DbModel
{
  abstract public function getDisplayName(): string;
  abstract public function primaryKey(): string;
}
