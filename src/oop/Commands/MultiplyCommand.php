<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 2/4/21
 * Time: 2:50 PM
 */

namespace src\oop\Commands;


class MultiplyCommand implements CommandInterface
{
    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        if (2 != sizeof($args)) {
            throw new \InvalidArgumentException('Not enough parameters');
        }

        return $args[0] * $args[1];
    }
}