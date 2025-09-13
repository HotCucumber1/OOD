<?php
declare(strict_types=1);

namespace App\Lab1\DuckFunctional\Entity;

use App\Lab1\DuckFunctional\Strategy\DanceBehavior;
use App\Lab1\DuckFunctional\Strategy\FlyBehavior;
use App\Lab1\DuckFunctional\Strategy\QuackBehavior;

class MallardDuck extends Duck
{
    public function __construct()
    {
        parent::__construct(
            FlyBehavior::flyWithWings(),
            QuackBehavior::quack(),
            DanceBehavior::danceWaltz(),
        );
    }

    public function display(): void
    {
        echo 'I am Mallard duck' . PHP_EOL;
    }
}
