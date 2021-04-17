<?php
declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class Auto
{
  private $plateNumber;
  public function __construct($number = "AUTO_NUMBER")
  {
    $this->setPlateNumber($number);
  }
  public function __destruct()
  {
    echo "Удаляем {$this->plateNumber}!<br>";
  }
  public function getPlateNumber()
  {
    return $this->plateNumber;
  }
  private function setPlateNumber($number)
  {
    $this->plateNumber = $number;
    return $this;
  }
}

$automobile = new Auto('7777');
echo $automobile->getPlateNumber() . "<br>";
$automobile2 = new Auto();
unset($automobile);
// echo "iii<br>";

class Website
{
  public const DE = 2;
  public const FR = 4;

  public static function sayHello($store)
  {
    if ($store == self::DE) {
      echo "Guten Tag<br>";
    } elseif ($store == self::FR) {
      echo "Bonjour<br>";
    }
  }
}

Website::sayHello(4);

