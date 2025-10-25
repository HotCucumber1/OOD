<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\Data\ParagraphInterface;

final class ReplaceTextCommand extends AbstractCommand
{
    private string $oldText;

    public function __construct(
        private readonly ParagraphInterface $paragraph,
        private readonly string             $newText,
    )
    {
    }

    public function replaceEdit(UndoableCommandInterface $edit): bool
    {
        if (!$edit instanceof self || $edit->paragraph !== $this->paragraph)
        {
            return false;
        }

        $this->oldText = $edit->oldText;
        return true;
    }

    protected function doExecute(): void
    {
        $this->oldText = $this->paragraph->getText();
        $this->paragraph->setText($this->newText);
    }

    protected function doUnexecute(): void
    {
        $this->paragraph->setText($this->oldText);
    }
}