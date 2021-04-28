<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class ShippedClass
{
  public $trackNumber;
  public $company;

  function __construct(string $trackNumber, $company)
  {
    $this->trackNumber = $trackNumber;
    $this->company = $company;
  }

  public function getTrackNumber()
  {
    return $this->trackNumber;
  }

  public function getCompany()
  {
    return $this->company;
  }

  public function viewTrackNumberAndCompany()
  {
    echo "<h1>$this->getTrackNumber</h1><br/><p>$this->company</p>";
  }
}

class statusDelivery extends ShippedClass
{
  public $status;
  function __construct($status, $trackNumber, $company)
  {
    parent::__construct($trackNumber, $company);
    $this->status = $status;
  }
  function viewInfo()
  {
    parent::getTrackNumber();
    echo "TrackNumber: $this->status";
  }
}

// вывод "1234" потому что мы не используем псевдопеременную указываующий в классе переменную для каждого экземпляра
class A
{
  public function foo()
  {
    static $x = 0;
    echo ++$x;
  }
}
$a1 = new A(); //Создаем экземпляр где метод
$a2 = new A(); //Создаем экземпляр тот же где функция эта ссылка на функцию в классе
$a1->foo(); // вызов функции увеличиваем на 1
$a2->foo(); // вызов функции увеличиваем на 1
$a1->foo(); // вызов функции увеличиваем на 1
$a2->foo(); // вызов функции увеличиваем на 1

class A
{
  public function foo()
  {
    static $x = 0;
    echo ++$x;
  }
}
class B extends A
{
}
$a1 = new A(); // Здесь создаем экземляр $а1 из класса А
$b1 = new B(); // Здесь создается новый экземпляр из класса В
$a1->foo(); // вызов функции увеличиваем на 1 экземпляр а1 = 1
$b1->foo(); // вызов функции увеличиваем на 1 экземпляр b1 = 2
$a1->foo(); // вызов функции увеличиваем на 1 экземпляр а1 = 1
$b1->foo(); // вызов функции увеличиваем на 1 экземпляр b1 = 2

class A
{
  public function foo()
  {
    static $x = 0;
    echo ++$x;
  }
}
class B extends A
{
}
// В отсутсвии аргументов в конструктуре класса, круглые скобки можно опустить
$a1 = new A;
$b1 = new B;
$a1->foo();
$b1->foo();
$a1->foo();
$b1->foo();
