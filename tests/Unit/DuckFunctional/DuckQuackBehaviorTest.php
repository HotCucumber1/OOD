<?php
declare(strict_types=1);

namespace Test\Unit\DuckFunctional;

use App\Lab1\DuckFunctional\Entity\MallardDuck;
use App\Lab1\DuckFunctional\Entity\RedHeadDuck;
use PHPUnit\Framework\TestCase;
use Test\Unit\DuckFunctional\Mock\Exception\QuackAction;
use Test\Unit\DuckFunctional\Mock\MockQuackBehavior;

class DuckQuackBehaviorTest extends TestCase
{
    public function testQuackAfterEvenFlyWhileCanFlySuccess(): void
    {
        $duck = new MallardDuck();
        $duck->setQuackBehavior(MockQuackBehavior::quack());

        $duck->performFly();
        $this->assertTrue(true);

        $this->expectException(QuackAction::class);
        $duck->performFly();
    }

    public function testNotQuackAfterEvenFlyWhileCanNotFlySuccess(): void
    {
        $duck = new RedHeadDuck();
        $duck->setQuackBehavior(MockQuackBehavior::quack());

        $duck->performFly();
        $this->assertTrue(true);

        $duck->performFly();
        $this->assertTrue(true);
    }
}
