<?php

namespace app\src\core;

use PDOException;

abstract class DBModel extends Model
{
  abstract public function tableName(): string;
  abstract public function attributes(): array;
  abstract public function primaryKey(): string;
  abstract public function getDisplayName(): string;

  public function save()
  {
    try {

      $tableName = $this->tableName();
      $attributes = $this->attributes();
      $params = array_map((function ($attr) {
        return ":$attr";
      }), $attributes);
      $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ")
      VALUES(" . implode(',', $params) . ")");
      foreach ($attributes as $attribute) {
        $statement->bindValue(":$attribute", $this->{$attribute});
      }

      $statement->execute();
      return true;
    } catch (\PDOException $e) {
      if ($e->getCode() === 23000) {
        //Здесь нужно отправить сообщение пользователю что данный email существует в базе данных
      } else {
        die('PDOException: ' . $e->getMessage());
      }
    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  public function findOne($where)
  {
    $tableName = static::tableName();
    $attributes = array_keys($where);
    $sql = implode("AND ", array_map((function ($attr) {
      return "$attr = :$attr";
    }), $attributes));

    $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
    foreach ($where as $key => $item) {
      $statement->bindValue(":$key", $item);
    }
    $statement->execute();
    return $statement->fetchObject(static::class);
  }

  public static function prepare($sql)
  {
    return Application::$app->db->pdo->prepare($sql);
  }
}
