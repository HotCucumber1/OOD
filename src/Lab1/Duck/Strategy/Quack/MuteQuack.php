<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Strategy\Quack;

class MuteQuack implements QuackBehaviorInterface
{
    public function quack(): void
    {
        echo 'Mute quack' . PHP_EOL;
    }
}