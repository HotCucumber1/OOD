<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Strategy\Fly;

interface FlyBehaviorInterface
{
    public function fly(): void;
    public function getFlightsNumber(): int;
}