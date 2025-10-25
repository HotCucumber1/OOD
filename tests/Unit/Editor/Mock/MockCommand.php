<?php
declare(strict_types=1);

namespace Test\Unit\Editor\Mock;

use App\Lab5\Editor\Command\AbstractCommand;
use App\Lab5\Editor\Command\UndoableCommandInterface;

class MockCommand extends AbstractCommand
{
    public function __construct(
        private int &$counter,
    )
    {
    }

    protected function doExecute(): void
    {
        $this->counter++;
    }

    protected function doUnexecute(): void
    {
        $this->counter--;
    }
}