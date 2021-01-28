<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 1/27/21
 * Time: 9:21 PM
 */

use PHPUnit\Framework\TestCase;

class SayHelloArgumentTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, sayHelloArgument($input));
    }

    public function positiveDataProvider()
    {
        return [
            ['words', 'Hello words'],
            [ 777, 'Hello 777'],
            [ true, 'Hello 1'],
        ];
    }
}


