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
    /**
     * @dataProvider negativeDataProvider
     */
    public function testNegative($input)
    {
        $this->expectException(InvalidArgumentException::class);
        sayHelloArgumentWrapper($input);
    }

    public function negativeDataProvider(){
        return [
            [['Hello'], ['word']],
            [[23], [2]]
        ];
    }
}