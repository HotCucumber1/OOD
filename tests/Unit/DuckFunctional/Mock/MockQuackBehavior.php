<?php
declare(strict_types=1);

namespace Test\Unit\DuckFunctional\Mock;

use Test\Unit\DuckFunctional\Mock\Exception\QuackAction;

class MockQuackBehavior
{
    public static function quack(): callable
    {
        return function (): void {
            throw new QuackAction();
        };
    }
}
