<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 2/4/21
 * Time: 3:03 PM
 */

namespace src\oop\Commands;


class ExponentiationCommand implements CommandInterface
{
    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        if (2 != sizeof($args)) {
            throw new \InvalidArgumentException('Not enough parameters');
        }

        return pow($args[0], $args[1]);
    }
}