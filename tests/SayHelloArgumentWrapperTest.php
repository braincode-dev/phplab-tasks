<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 1/27/21
 * Time: 9:46 PM
 */

use PHPUnit\Framework\TestCase;

class SayHelloArgumentWrapperTest extends TestCase
{

    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);

        sayHelloArgumentWrapper(1.2, null, [1,2,3,4,5,6,7]);
    }
}