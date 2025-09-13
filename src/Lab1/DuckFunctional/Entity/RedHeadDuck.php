<?php
declare(strict_types=1);

namespace App\Lab1\DuckFunctional\Entity;


use App\Lab1\DuckFunctional\Strategy\DanceBehavior;
use App\Lab1\DuckFunctional\Strategy\FlyBehavior;
use App\Lab1\DuckFunctional\Strategy\QuackBehavior;

class RedHeadDuck extends Duck
{
    public function __construct()
    {
        parent::__construct(
            FlyBehavior::flyNoWay(),
            QuackBehavior::squeak(),
            DanceBehavior::danceMinuet(),
        );
    }

    public function display(): void
    {
        echo 'I am Red head duck' . PHP_EOL;
    }
}
