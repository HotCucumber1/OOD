<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Strategy\Quack;

interface QuackBehaviorInterface
{
    public function quack(): void;
}