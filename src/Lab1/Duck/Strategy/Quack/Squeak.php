<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Strategy\Quack;

class Squeak implements QuackBehaviorInterface
{
    public function quack(): void
    {
        echo 'Squeak' . PHP_EOL;
    }
}