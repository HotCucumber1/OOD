<?php
declare(strict_types=1);

namespace App\Lab1\DuckFunctional\Strategy;

abstract class FlyBehavior
{
    public static function flyWithWings(): callable
    {
        $flightsCount = 0;

        return function () use (&$flightsCount): int {
            echo 'Fly with wings' . PHP_EOL;
            return ++$flightsCount;
        };
    }

    public static function flyNoWay(): callable
    {
        return function (): int {
            echo 'Fly no way' . PHP_EOL;
            return 0;
        };
    }
}
