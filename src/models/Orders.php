<?php

namespace app\src\models;

use app\src\core\DbModel;
use app\src\core\UserModel;

class Orders extends DbModel
{
  public string $id;
  public string $status;

  public function tableName(): string
  {
    return 'orders';
  }

  public function attributes(): array
  {
    return ['status'];
  }

  public function rules(): array
  {
    return [
      'name' => [self::RULE_REQUIRED],
    ];
  }

  public function ordersShow()
  {
    $orders = DbModel::findAll();
    if (!$orders) {
      $this->addError('orders', 'Заказов нет');
      return false;
    }
    return $orders;
  }

  public function changeStatus($where)
  {
    return parent::saveOne($where);
  }
}