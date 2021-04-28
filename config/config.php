<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class DB
{
  const DB_TYPE = 'mysql';
  const DB_HOST = '127.0.0.1:3306';
  const DB_NAME = 'shop';
  const DB_USER = 'root';
  const DB_PASS = '';

  public static function getDbConnection(): PDO
  {
    static $connection = null;
    if (empty($connection)) {
      $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING];
      $connection = new PDO(self::DB_TYPE . ':host=' . self::DB_HOST . ';dbname=' . self::DB_NAME, self::DB_USER, self::DB_PASS, $options);
    }
    return $connection;
  }
}
