<?php
/**
 * Created by PhpStorm.
 * User: alexkizyma
 * Date: 2/4/21
 * Time: 3:00 PM
 */

namespace src\oop\Commands;


class DivisionCommand implements CommandInterface
{
    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        if (2 != sizeof($args)) {
            throw new \InvalidArgumentException('Not enough parameters');
        }

        return $args[0] / $args[1];
    }
}