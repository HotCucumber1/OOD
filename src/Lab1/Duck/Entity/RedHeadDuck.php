<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Entity;

use App\Lab1\Duck\Strategy\Dance\DanceMinuet;
use App\Lab1\Duck\Strategy\Fly\FlyNoWay;
use App\Lab1\Duck\Strategy\Quack\Squeak;

class RedHeadDuck extends Duck
{
    public function __construct()
    {
        parent::__construct(
            new FlyNoWay(),
            new Squeak(),
            new DanceMinuet(),
        );
    }

    public function display(): void
    {
        echo 'I am Red head duck' . PHP_EOL;
    }
}
