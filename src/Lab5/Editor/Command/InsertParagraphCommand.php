<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\DocumentInterface;

readonly class InsertParagraphCommand implements CommandInterface
{
    public function __construct(
        private DocumentInterface $document,
        private string            $text,
        private ?int              $position = null,
    )
    {
    }

    public function execute(): void
    {
        $this->document->insertParagraph(
            $this->text,
            $this->position,
        );
    }

    public function unexecute(): void
    {
        // TODO: Implement unexecute() method.
    }
}