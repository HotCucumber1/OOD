<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\Data\ImageInterface;
use App\Lab5\Editor\Document\DocumentInterface;

readonly class ResizeImageCommand implements CommandInterface
{
    public function __construct(
        private DocumentInterface $document,
        private int               $itemIndex,
        private int               $newWidth,
        private int               $newHeight,
    )
    {
    }

    public function execute(): void
    {
        // TODO склейка
        $item = $this->document->getItem($this->itemIndex);
        if (!$item instanceof ImageInterface)
        {
            echo "Item {$this->itemIndex} is not image" . PHP_EOL;
            return;
        }

        $item->resize($this->newWidth, $this->newHeight);
    }

    public function unexecute(): void
    {
        // TODO: Implement unexecute() method.
    }
}