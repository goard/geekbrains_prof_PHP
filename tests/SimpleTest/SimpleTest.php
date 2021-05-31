<?php

namespace SimpleTest;

use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
  public function testSimple()
  {
    $this->assertEquals(3, (int)pi());
  }
}