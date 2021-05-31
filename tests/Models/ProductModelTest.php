<?php

namespace app\tests\Models;

use app\src\models\Product;
use PHPUnit\Framework\TestCase;

class ProductModelTest extends TestCase
{
  private $object;

  protected function setUp() : void
  {
    $this->object = new Product();
  }

  public function testIDNotCurrentGoods()
  {
    $this->object->id = 2;
    $this->expectException($this->object->productShow());
  }

  public function testReturnObj()
  {
    $this->assertIsObject($this->object->productShow());
    $this->assertIsString($this->object->productShow()->name);
  }
}
