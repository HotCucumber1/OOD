<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\DocumentInterface;

readonly class SaveCommand implements CommandInterface
{
    public function __construct(
        private DocumentInterface $document,
        private string            $fileUrl,
    )
    {
    }

    public function execute(): void
    {
        $this->document->save($this->fileUrl);
    }

    public function unexecute(): void
    {
        // TODO: Implement unexecute() method.
    }
}