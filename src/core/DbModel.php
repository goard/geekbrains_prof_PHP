<?php

namespace app\src\core;

use PDO;

abstract class DbModel extends Model
{
  abstract public function tableName(): string;

  abstract public function attributes(): array;

  public function save()
  {
    try {
      $tableName = $this->tableName();
      $attributes = $this->attributes();
      $params = array_map(fn ($attr) => ":$attr", $attributes);
      $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ")
      VALUES(" . implode(',', $params) . ")");
      foreach ($attributes as $attribute) {
        $statement->bindValue(":$attribute", $this->{$attribute});
      }
      var_dump($statement);
      $statement->execute();
      return true;
    } catch (\Throwable $th) {
      throw $th;
    } catch (\PDOException $e) {
      if ($e->getCode() === 23000) {
        //Здесь нужно отправить сообщение пользователю что данный email существует в базе данных
        die('PDOException: ' . $e->getMessage());
      } else {
        die('PDOException: ' . $e->getMessage());
      }
    }
  }

  public function findOne($where)
  {
    $tableName = static::tableName();
    $attributes = array_keys($where);
    $sql = implode("AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
    $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
    foreach ($where as $key => $item) {
      $statement->bindValue(":$key", $item);
    }

    $statement->execute();
    return $statement->fetchObject(static::class);
  }

  public function findAll()
  {
    $tableName = static::tableName();
    $statement = self::prepare("SELECT * FROM $tableName ORDER BY created_at desc");

    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function saveOne($where)
  {
    try {
      $tableName = $this->tableName();
      $attributes = $this->attributes();
      $arr = array_map(fn ($attr) => "$attr = :$attr", $attributes);
      $statement = self::prepare("UPDATE $tableName SET " . implode(',', $arr) ." WHERE id = $where");
      foreach ($attributes as $attribute) {
        $statement->bindValue(":$attribute", $this->{$attribute});
      }
      $statement->execute();
      return true;
    } catch (\Throwable $th) {
      throw $th;
    } catch (\PDOException $e) {
      die('PDOException: ' . $e->getMessage());
    }
  }

  public static function prepare($sql)
  {
    return Application::$app->db->pdo->prepare($sql);
  }
}
