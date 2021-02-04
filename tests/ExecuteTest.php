<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 2/4/21
 * Time: 9:06 PM
 */

use PHPUnit\Framework\TestCase;

class ExecuteTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, execute($input));
    }

    public function positiveDataProvider()
    {
        return [
            [5, [4, 1]],
            [5, [4, 1]],
        ];
    }
}