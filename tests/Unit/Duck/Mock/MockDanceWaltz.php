<?php
declare(strict_types=1);

namespace Test\Unit\Duck\Mock;

use App\Lab1\Duck\Strategy\Dance\DanceBehaviorInterface;
use Test\Unit\Duck\Mock\Exception\DanceWaltzAction;

class MockDanceWaltz implements DanceBehaviorInterface
{
    /**
     * @throws DanceWaltzAction
     */
    public function dance(): void
    {
        throw new DanceWaltzAction();
    }
}