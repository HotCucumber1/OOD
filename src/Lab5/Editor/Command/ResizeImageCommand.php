<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\Data\ImageInterface;

final class ResizeImageCommand extends AbstractCommand
{
    private int $oldWidth;
    private int $oldHeight;

    public function __construct(
        private readonly ImageInterface $image,
        private readonly int            $newWidth,
        private readonly int            $newHeight,
    )
    {
    }

    protected function doExecute(): void
    {
        // TODO склейка
        $this->oldWidth = $this->image->getWidth();
        $this->oldHeight = $this->image->getHeight();

        $this->image->resize(
            $this->newWidth,
            $this->newHeight,
        );
    }

    protected function doUnexecute(): void
    {
        $this->image->resize(
            $this->oldWidth,
            $this->oldHeight,
        );
    }
}