<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

interface UndoableCommandInterface extends CommandInterface
{
    public function replaceEdit(UndoableCommandInterface $edit): bool;
}