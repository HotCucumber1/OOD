<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\DocumentInterface;

readonly class DeleteItemCommand implements CommandInterface
{
    public function __construct(
        private DocumentInterface $document,
        private int               $index,
    )
    {
    }

    public function execute(): void
    {
        $this->document->deleteItem($this->index);
    }

    public function unexecute(): void
    {

    }
}