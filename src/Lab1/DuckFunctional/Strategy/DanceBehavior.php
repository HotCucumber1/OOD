<?php
declare(strict_types=1);

namespace App\Lab1\DuckFunctional\Strategy;

abstract class DanceBehavior
{
    public static function danceMinuet(): callable
    {
        return function (): void {
            echo 'Dance minuet' . PHP_EOL;
        };
    }

    public static function danceWaltz(): callable
    {
        return function (): void {
            echo 'Dance waltz' . PHP_EOL;
        };
    }
}
