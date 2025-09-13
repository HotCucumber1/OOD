<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Strategy\Fly;

class FlyWithWings implements FlyBehaviorInterface
{
    private int $flightsNumber = 0;

    public function fly(): void
    {
        echo 'Fly with wings' . PHP_EOL;
        $this->flightsNumber++;
    }

    public function getFlightsNumber(): int
    {
        return $this->flightsNumber;
    }
}