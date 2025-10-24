<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;


final class SetTitleCommand extends AbstractCommand
{
    private string $oldTitle;

    public function __construct(
        private string          &$title,
        private readonly string $newTitle,
    )
    {
    }

    protected function doExecute(): void
    {
        $this->oldTitle = $this->title;
        $this->title = $this->newTitle;
    }

    protected function doUnexecute(): void
    {
        $this->title = $this->oldTitle;
    }
}