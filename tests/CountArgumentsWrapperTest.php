<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 1/27/21
 * Time: 10:34 PM
 */

use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
{
    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);

        countArgumentsWrapper(33);
    }
}