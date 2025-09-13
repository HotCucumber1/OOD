<?php
declare(strict_types=1);

namespace Test\Unit\DuckFunctional;

use App\Lab1\DuckFunctional\Entity\MallardDuck;
use PHPUnit\Framework\TestCase;
use Test\Unit\DuckFunctional\Mock\Exception\DanceMinuetAction;
use Test\Unit\DuckFunctional\Mock\Exception\DanceWaltzAction;
use Test\Unit\DuckFunctional\Mock\MockDanceBehavior;

class DuckDanceBehaviorTest extends TestCase
{
    public function testMallardDuckDanceWaltzSuccess()
    {
        $duck = new MallardDuck();
        $duck->setDanceBehavior(MockDanceBehavior::danceWaltz());

        $this->expectException(DanceWaltzAction::class);
        $duck->performDance();
    }

    public function testRedHeadDuckDanceMinuetSuccess()
    {
        $duck = new MallardDuck();
        $duck->setDanceBehavior(MockDanceBehavior::danceMinuet());

        $this->expectException(DanceMinuetAction::class);
        $duck->performDance();
    }
}