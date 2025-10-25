<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Command\Exception\FileNotFound;
use App\Lab5\Editor\Document\Data\Image;
use App\Lab5\Editor\Document\Exception\InvalidItemIndexException;
use App\Lab5\Editor\Utils\ImageSaveStrategyInterface;

final class InsertImageCommand extends AbstractCommand
{
    private string $newUrl;
    private bool $isToDeleteState = true;

    public function __construct(
        private array                               &$items,
        private readonly string                     $imageUrl,
        private readonly int                        $width,
        private readonly int                        $height,
        private ?int                                $position,
        private readonly ImageSaveStrategyInterface $imageService,
    )
    {
    }

    /**
     * @throws FileNotFound
     */
    public function __destruct()
    {
        if (!$this->isToDeleteState)
        {
            return;
        }
        unlink($this->newUrl);
    }

    /**
     * @throws InvalidItemIndexException
     */
    protected function doExecute(): void
    {
        $this->newUrl = $this->imageService->saveImage($this->imageUrl);
        $image = new Image($this->newUrl, $this->width, $this->height);

        if (is_null($this->position))
        {
            $this->items[] = $image;
            return;
        }
        if ($this->position !== 0 && $this->position >= count($this->items))
        {
            throw new InvalidItemIndexException();
        }
        array_splice($this->items, $this->position, 0, [$image]);
        $this->isToDeleteState = false;
    }

    protected function doUnexecute(): void
    {
        if (is_null($this->position))
        {
            $this->position = count($this->items) - 1;
        }
        unset($this->items[$this->position]);
        $this->isToDeleteState = true;
    }
}