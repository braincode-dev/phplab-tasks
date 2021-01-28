<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 1/27/21
 * Time: 8:57 PM
 */

use PHPUnit\Framework\TestCase;

class SayHelloTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($expected)
    {
        $this->assertEquals($expected, sayHello());
    }

    public function positiveDataProvider()
    {
        return [
            ['Hello' ]
        ];
    }
}