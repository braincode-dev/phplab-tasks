<?php

use PHPUnit\Framework\TestCase;
use src\oop\Commands\ExponentiationCommand;

class ExponentiationCommandTest extends TestCase
{
    /**
     * @var ExponentiationCommand
     */
    private $command;

    /**
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     *
     * @inheritdoc
     */
    public function setUp(): void
    {
        $this->command = new ExponentiationCommand();
    }

    /**
     * @return array
     */
    public function commandPositiveDataProvider()
    {
        return [
            [4, 5, 1024],
            [2.1, 1.1, 2.26173242464],
            [-6, 3, -216],
            ['15', 3, 3375],
        ];
    }

    /**
     * @dataProvider commandPositiveDataProvider
     */
    public function testCommandPositive($a, $b, $expected)
    {
        $result = $this->command->execute($a, $b);

        $this->assertEquals($expected, $result);
    }

    public function testCommandNegative()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->command->execute(3);
    }

    /**
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     *
     * @inheritdoc
     */
    public function tearDown(): void
    {
        unset($this->command);
    }
}