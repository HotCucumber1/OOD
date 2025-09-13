<?php
declare(strict_types=1);

namespace App\Lab1\DuckFunctional\Entity;

abstract class Duck
{
    private $flyBehavior;
    private $quackBehavior;
    private $danceBehavior;

    public function __construct(
        callable $flyBehavior,
        callable $quackBehavior,
        callable $danceBehavior,
    )
    {
        $this->flyBehavior = $flyBehavior;
        $this->quackBehavior = $quackBehavior;
        $this->danceBehavior = $danceBehavior;
    }

    public function performQuack(): void
    {
        call_user_func($this->quackBehavior);
    }

    public function performFly(): void
    {
        $flightsNumber = call_user_func($this->flyBehavior);
        if (self::shouldQuack($flightsNumber))
        {
            $this->quackWithPleasure();
        }
    }

    public function performDance(): void
    {
        call_user_func($this->danceBehavior);
    }

    public function setDanceBehavior(callable $danceBehavior): void
    {
        $this->danceBehavior = $danceBehavior;
    }

    public function setQuackBehavior(callable $quackBehavior): void
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
        return $flightsNumber !== 0 && $flightsNumber % 2 === 0;
    }
}
