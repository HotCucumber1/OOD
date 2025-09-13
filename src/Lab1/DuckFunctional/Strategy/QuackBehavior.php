<?php
declare(strict_types=1);

namespace App\Lab1\DuckFunctional\Strategy;

abstract class QuackBehavior
{
    public static function quack(): callable
    {
        return function (): void {
            echo 'Quack' . PHP_EOL;
        };
    }

    public static function muteQuack(): callable
    {
        return function (): void {
            echo 'Mute quack' . PHP_EOL;
        };
    }

    public static function squeak(): callable
    {
        return function (): void {
            echo 'Squeak' . PHP_EOL;
        };
    }
}
