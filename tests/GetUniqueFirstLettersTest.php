<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 1/30/21
 * Time: 12:25 PM
 */

use PHPUnit\Framework\TestCase;

class GetUniqueFirstLettersTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, getUniqueFirstLetters($input));
    }

    public function positiveDataProvider()
    {
        return [
            [
                [
                    ['name' => 'Andrea'],
                    ['name' => 'Andry'],
                    ['name' => 'Bobby'],
                    ['name' => 'Dory'],
                    ['name' => 'Donald']
                ],
                ['A', 'B', 'D']
            ]
        ];
    }
}