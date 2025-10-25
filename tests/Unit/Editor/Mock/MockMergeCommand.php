<?php
declare(strict_types=1);

namespace Test\Unit\Editor\Mock;

use App\Lab5\Editor\Command\AbstractCommand;
use App\Lab5\Editor\Command\UndoableCommandInterface;

class MockMergeCommand extends AbstractCommand
{
    public function replaceEdit(UndoableCommandInterface $edit): bool
    {
        return true;
    }

    protected function doExecute(): void
    {
    }

    protected function doUnexecute(): void
    {
    }
}
