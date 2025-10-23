<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document;

use App\Lab5\Editor\Command\CommandInterface;
use App\Lab5\Editor\Document\Data\DocumentItemInterface;
use App\Lab5\Editor\Document\Data\Image;
use App\Lab5\Editor\Document\Data\Paragraph;
use App\Lab5\Editor\Document\Exception\FailedToSaveFileException;
use App\Lab5\Editor\Document\Exception\InvalidItemIndexException;
use App\Lab5\Editor\Utils\HtmlSerializer;
use App\Lab5\Editor\Utils\ImageService;

class Document implements DocumentInterface
{
    /**
     * @var CommandInterface[]
     */
    private array $commands = [];

    /**
     * @var DocumentItemInterface[]
     */
    private array $items = [];

    private int $currentCommandIndex = 0;

    private string $title = '';

    /**
     * @throws InvalidItemIndexException
     */
    public function insertParagraph(string $content, ?int $position): void
    {
        $this->insertItem(
            new Paragraph($content),
            $position,
        );
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function insertImage(string $imageUrl, int $width, int $height, ?int $position = null): void
    {
        $newUrl = ImageService::saveImage($imageUrl);

        $this->insertItem(
            new Image($newUrl, $width, $height),
            $position,
        );
    }

    public function getItemsCount(): int
    {
        return count($this->items);
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function getItem(int $index): DocumentItemInterface
    {
        $this->assertItemIsSet($index);
        return $this->items[$index];
    }

    /**
     * @inheritDoc
     */
    public function listItems(): array
    {
        return $this->items;
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function deleteItem(int $index): void
    {
        $this->assertItemIsSet($index);
        unset($this->items[$index]);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function canUndo(): bool
    {
        return true;
        // TODO: Implement canUndo() method.
    }

    public function undo(): void
    {
        // TODO: Implement undo() method.
    }

    public function canRedo(): bool
    {
        return true;
        // TODO: Implement canRedo() method.
    }

    public function redo(): void
    {
        // TODO: Implement redo() method.
    }

    /**
     * @throws FailedToSaveFileException
     */
    public function save(string $path): void
    {
        $documentConten = HtmlSerializer::serialize($this);
        if (!file_put_contents($path, $documentConten))
        {
            throw new FailedToSaveFileException($path);
        }
    }

    /**
     * @throws InvalidItemIndexException
     */
    private function insertItem(DocumentItemInterface $item, ?int $position): void
    {
        if (is_null($position))
        {
            $this->items[] = $item;
            return;
        }
        if ($position >= count($this->items))
        {
            throw new InvalidItemIndexException();
        }
        array_splice($this->items, $position, 0, $item);
    }

    /**
     * @throws InvalidItemIndexException
     */
    private function assertItemIsSet(int $index): void
    {
        if (!isset($this->items[$index]))
        {
            throw new InvalidItemIndexException();
        }
    }
}
