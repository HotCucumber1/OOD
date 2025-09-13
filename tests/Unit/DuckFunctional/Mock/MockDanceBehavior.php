<?php
declare(strict_types=1);

namespace Test\Unit\DuckFunctional\Mock;

use Test\Unit\DuckFunctional\Mock\Exception\DanceMinuetAction;
use Test\Unit\DuckFunctional\Mock\Exception\DanceWaltzAction;

class MockDanceBehavior
{
    public static function danceMinuet(): callable
    {
        return function (): void {
            throw new DanceMinuetAction();
        };
    }

    public static function danceWaltz(): callable
    {
        return function (): void {
            throw new DanceWaltzAction();
        };
    }
}
