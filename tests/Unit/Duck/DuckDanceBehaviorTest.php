<?php
declare(strict_types=1);

namespace Test\Unit\Duck;

use App\Lab1\Duck\Entity\MallardDuck;
use PHPUnit\Framework\TestCase;
use Test\Unit\Duck\Mock\Exception\DanceMinuetAction;
use Test\Unit\Duck\Mock\Exception\DanceWaltzAction;
use Test\Unit\Duck\Mock\MockDanceMinuet;
use Test\Unit\Duck\Mock\MockDanceWaltz;

class DuckDanceBehaviorTest extends TestCase
{
    public function testMallardDuckDanceWaltzSuccess()
    {
        $duck = new MallardDuck();
        $duck->setDanceBehavior(new MockDanceWaltz());

        $this->expectException(DanceWaltzAction::class);
        $duck->performDance();
    }

    public function testRedHeadDuckDanceMinuetSuccess()
    {
        $duck = new MallardDuck();
        $duck->setDanceBehavior(new MockDanceMinuet());

        $this->expectException(DanceMinuetAction::class);
        $duck->performDance();
    }
}