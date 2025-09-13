<?php
declare(strict_types=1);

namespace Test\Unit\Duck\Mock;

use App\Lab1\Duck\Strategy\Dance\DanceBehaviorInterface;
use Test\Unit\Duck\Mock\Exception\DanceMinuetAction;

class MockDanceMinuet implements DanceBehaviorInterface
{
    /**
     * @throws DanceMinuetAction
     */
    public function dance(): void
    {
        throw new DanceMinuetAction();
    }
}