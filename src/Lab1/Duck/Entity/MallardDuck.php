<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Entity;

use App\Lab1\Duck\Strategy\Dance\DanceWaltz;
use App\Lab1\Duck\Strategy\Fly\FlyWithWings;
use App\Lab1\Duck\Strategy\Quack\Quack;

class MallardDuck extends Duck
{
    public function __construct()
    {
        parent::__construct(
            new FlyWithWings(),
            new Quack(),
            new DanceWaltz(),
        );
    }

    public function display(): void
    {
        echo 'I am Mallard duck' . PHP_EOL;
    }
}
