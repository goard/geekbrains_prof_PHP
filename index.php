<?php
declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

abstract class MyAbstactProduct {
  protected $quantity;
  protected $price;
  function __construct( int $quantity, int $price)
  {
    $this->quantity = $quantity;
    $this->price = $price;
  }
  abstract protected function FinalСost();
  public function getCost()
  {
    echo $this->FinalСost();
  }
}

class DigitalProduct extends MyAbstactProduct {
  protected function FinalСost()
  {
    return "digital product cost = " . $this->quantity * $this->price . "<br>";
  }
}

class PieceGoods extends MyAbstactProduct {
  protected function FinalСost()
  {
    return "piece goods cost = " . $this->quantity * $this->price . "<br>";
  }
}

class WeightGoods extends MyAbstactProduct {
  protected function FinalСost()
  {
    if ($this->quantity < 2.5)
      return "weight goods cost = " . $this->quantity * $this->price . "<br>";
    if ($this->quantity > 2.5 && $this->quantity < 20)
      return "weight goods cost = " . $this->quantity * ($this->price - $this->price * 0.1) . "<br>";
    else {
      return "weight goods cost = " . $this->quantity * $this->price * 0.25 . "<br>";
    }
  }
}

$DP = new DigitalProduct(2, 45);
$DP->getCost();

$PG = new PieceGoods(3, 45);
$PG->getCost();

$WG = new WeightGoods(21, 45);
$WG->getCost();