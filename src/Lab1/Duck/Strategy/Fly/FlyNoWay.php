<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Strategy\Fly;

class FlyNoWay implements FlyBehaviorInterface
{
    public function fly(): void
    {
    }

    public function getFlightsNumber(): int
    {
        return 0;
    }
}