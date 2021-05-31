<?php

namespace app\src\models;

use app\src\core\DbModel;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class Product extends DbModel
{
  public string $id;
  public string $status;

  public function tableName(): string
  {
    return 'goods';
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

  public function productShow()
  {
    try {
      $product = DbModel::findOne(['id' => $this->id]);
      if (!$product) {
        $this->addError('product', 'Выбранного товара нет');
        throw new Exception('Выбранного товара нет');
        return $this;
      }
      return $product;
    } catch (\Exception $e) {
      //throw $th;
      return $e;
    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  public function getData()
  {
    return $this->data;
  }
}
