<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 1/27/21
 * Time: 10:11 PM
 */

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, countArguments($input));
    }

    public function positiveDataProvider()
    {
        return [

            [

                [], // nothing
                [
                    'argument_count' => 1,
                    'argument_values' => [[]],
                ]
            ],
            [
                ['World'],
                [
                    'argument_count' => 1,
                    'argument_values' => [['World']],
                ]
            ],
            [
                ['Hello', 'World'],
                [
                    'argument_count' => 1,
                    'argument_values' => [['Hello', 'World']],
                ]
            ],
        ];
    }
}