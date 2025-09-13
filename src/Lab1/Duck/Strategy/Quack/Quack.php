<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Strategy\Quack;

class Quack implements QuackBehaviorInterface
{
    public function quack(): void
    {
        echo 'Quack' . PHP_EOL;
    }
}