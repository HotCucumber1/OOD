<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Command\Exception\FileNotFound;
use App\Lab5\Editor\Document\Data\Image;
use App\Lab5\Editor\Document\Exception\InvalidItemIndexException;
use App\Lab5\Editor\Utils\ImageService;

final class InsertImageCommand extends AbstractCommand
{
    private string $newUrl;
    private bool $isToDelete = false;

    public function __construct(
        private array           &$items,
        private readonly string $imageUrl,
        private readonly int    $width,
        private readonly int    $height,
        private ?int            $position = null,
    )
    {
    }

    /**
     * @throws FileNotFound
     */
    public function __destruct()
    {
        if (!$this->isToDelete)
        {
            return;
        }
        if (!file_exists($this->newUrl))
        {
            throw new FileNotFound($this->newUrl);
        }
        if (!unlink($this->newUrl))
        {
            throw new \RuntimeException('Failed to delete file.');
        }
    }

    /**
     * @throws InvalidItemIndexException
     */
    protected function doExecute(): void
    {
        $this->newUrl = ImageService::saveImage($this->imageUrl);

        $image = new Image($this->newUrl, $this->width, $this->height);
        if (is_null($this->position))
        {
            $this->items[] = $image;
            return;
        }
        if ($this->position >= count($this->items))
        {
            throw new InvalidItemIndexException();
        }
        array_splice($this->items, $this->position, 0, $image);
        $this->isToDelete = false;
    }

    protected function doUnexecute(): void
    {
        if (is_null($this->position))
        {
            $this->position = count($this->items) - 1;
        }
        unset($this->items[$this->position]);
        $this->isToDelete = true;
    }
}