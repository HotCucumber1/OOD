<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\DocumentInterface;

readonly class SetTitleCommand implements CommandInterface
{
    public function __construct(
        private DocumentInterface $document,
        private string            $newTitle,
    )
    {
    }

    public function execute(): void
    {
        $this->document->setTitle($this->newTitle);
    }

    public function unexecute(): void
    {
        // TODO: Implement unexecute() method.
    }
}