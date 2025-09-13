<?php
declare(strict_types=1);

namespace App\Lab1\Duck\Strategy\Dance;

class DanceWaltz implements DanceBehaviorInterface
{
    public function dance(): void
    {
        echo 'Dance waltz' . PHP_EOL;
    }
}