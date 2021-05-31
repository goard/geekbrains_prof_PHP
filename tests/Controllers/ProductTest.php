<?php

namespace app\tests\Controllers;

use app\src\controllers\AuthController;
use app\src\core\Request;
use PHPUnit\Framework\TestCase;
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;

class ProductTest extends TestCase
{
  private $object;

  protected function setUp(): void
  {
    $this->object = new AuthController();
  }

  /**
   * @dataProvider additionProvider
   */
  public function testError()
  {
    $request = new Request();


    // var_dump($request->getPath());
    $this->expectException($this->object->product($request));
  }

  public function additionProvider()
  {
    return [[
      $_SERVER['REQUEST_URI'] = '/profphp/product?id=2',
      $_SERVER['REQUEST_METHOD'] = 'GET',
    ]];
  }
}
