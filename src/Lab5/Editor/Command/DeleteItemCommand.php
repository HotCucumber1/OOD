<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Command\Exception\FileNotFound;
use App\Lab5\Editor\Document\Data\DocumentItemInterface;
use App\Lab5\Editor\Document\Data\ImageInterface;
use App\Lab5\Editor\Document\Exception\InvalidItemIndexException;

final class DeleteItemCommand extends AbstractCommand
{
    private DocumentItemInterface $restoreItem;
    private bool $isToDelete = true;
    private string $imageUrl;

    public function __construct(
        private array        &$items,
        private readonly int $index,
    )
    {
    }

    /**
     * @throws FileNotFound
     */
    public function __destruct()
    {
        if (!$this->isToDelete || !isset($this->imageUrl))
        {
            return;
        }
        if (!file_exists($this->imageUrl))
        {
            throw new FileNotFound($this->imageUrl);
        }
        if (!unlink($this->imageUrl))
        {
            throw new \RuntimeException('Failed to delete file.');
        }
    }

    /**
     * @throws InvalidItemIndexException
     */
    protected function doExecute(): void
    {
        if (!isset($this->items[$this->index]))
        {
            throw new InvalidItemIndexException();
        }
        $this->restoreItem = clone $this->items[$this->index];
        if ($this->restoreItem instanceof ImageInterface)
        {
            $this->imageUrl = $this->restoreItem->getImageUrl();
        }

        unset($this->items[$this->index]);
        $this->isToDelete = true;
    }

    protected function doUnexecute(): void
    {
        $this->items[$this->index] = $this->restoreItem;
        $this->isToDelete = false;
    }
}