<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Entity;

use App\Lab1\Duck\Strategy\Dance\DanceBehaviorInterface;
use App\Lab1\Duck\Strategy\Fly\FlyBehaviorInterface;
use App\Lab1\Duck\Strategy\Quack\QuackBehaviorInterface;

abstract class Duck
{
    public function __construct(
        private FlyBehaviorInterface   $flyBehavior,
        private QuackBehaviorInterface $quackBehavior,
        private DanceBehaviorInterface $danceBehavior,
    )
    {
    }

    public function performQuack(): void
    {
        $this->quackBehavior->quack();
    }

    public function performFly(): void
    {
        $this->flyBehavior->fly();

        $flightsNumber = $this->flyBehavior->getFlightsNumber();
        if (self::shouldQuack($flightsNumber))
        {
            $this->quackWithPleasure();
        }
    }

    public function performDance(): void
    {
        $this->danceBehavior->dance();
    }

    public function setDanceBehavior(DanceBehaviorInterface $danceBehavior): void
    {
        $this->danceBehavior = $danceBehavior;
    }

    public function setQuackBehavior(QuackBehaviorInterface $quackBehavior): void
    {
        $this->quackBehavior = $quackBehavior;
    }

    abstract function display(): void;

    private function quackWithPleasure(): void
    {
        echo 'With pleasure: ';
        $this->performQuack();
    }

    private static function shouldQuack(int $flightsNumber): bool
    {
        return $flightsNumber !== 0 &&
            $flightsNumber % 2 === 0;
    }
}
