<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\DocumentInterface;

readonly class InsertImageCommand implements CommandInterface
{
    public function __construct(
        private DocumentInterface $document,
        private string $imageUrl,
        private int $width,
        private int $height,
        private ?int $position = null,
    )
    {
    }

    public function execute(): void
    {
        $this->document->insertImage(
            $this->imageUrl,
            $this->width,
            $this->height,
            $this->position,
        );
    }

    public function unexecute(): void
    {
        // TODO: Implement unexecute() method.
    }
}