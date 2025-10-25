<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

abstract class AbstractUndoableCommand implements UndoableCommandInterface
{
    public function replaceEdit(UndoableCommandInterface $edit): bool
    {
        return false;
    }
}