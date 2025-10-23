<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\Data\ParagraphInterface;
use App\Lab5\Editor\Document\DocumentInterface;

readonly class ReplaceTextCommand implements CommandInterface
{
    public function __construct(
        private DocumentInterface $document,
        private int               $itemIndex,
        private string            $newText,
    )
    {
    }

    public function execute(): void
    {
        // TODO склейка
        $item = $this->document->getItem($this->itemIndex);
        if (!$item instanceof ParagraphInterface)
        {
            echo "Item {$this->itemIndex} is not paragraph" . PHP_EOL;
            return;
        }

        $item->setText($this->newText);
    }

    public function unexecute(): void
    {
        // TODO: Implement unexecute() method.
    }
}