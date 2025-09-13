<?php
declare(strict_types=1);

namespace Test\Unit\Duck;

use App\Lab1\Duck\Entity\MallardDuck;
use App\Lab1\Duck\Entity\RedHeadDuck;
use PHPUnit\Framework\TestCase;
use Test\Unit\Duck\Mock\Exception\QuackAction;
use Test\Unit\Duck\Mock\MockQuack;

class DuckQuackBehaviorTest extends TestCase
{
    public function testQuackAfterEvenFlyWhileCanFlySuccess(): void
    {
        $duck = new MallardDuck();
        $duck->setQuackBehavior(new MockQuack());

        $duck->performFly();
        $this->assertTrue(true);

        $this->expectException(QuackAction::class);
        $duck->performFly();
    }

    public function testNotQuackAfterEvenFlyWhileCanNotFlySuccess(): void
    {
        $duck = new RedHeadDuck();
        $duck->setQuackBehavior(new MockQuack());

        $duck->performFly();
        $this->assertTrue(true);

        $duck->performFly();
        $this->assertTrue(true);
    }
}
