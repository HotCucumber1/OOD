<?php
declare(strict_types=1);

namespace Test\Unit\Duck\Mock;

use App\Lab1\Duck\Strategy\Quack\QuackBehaviorInterface;
use Test\Unit\Duck\Mock\Exception\QuackAction;

class MockQuack implements QuackBehaviorInterface
{
    /**
     * @throws QuackAction
     */
    public function quack(): void
    {
        throw new QuackAction();
    }
}