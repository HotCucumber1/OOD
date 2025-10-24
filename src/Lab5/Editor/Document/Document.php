<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document;

use App\Lab5\Editor\Command\DeleteItemCommand;
use App\Lab5\Editor\Command\InsertImageCommand;
use App\Lab5\Editor\Command\InsertParagraphCommand;
use App\Lab5\Editor\Command\ReplaceTextCommand;
use App\Lab5\Editor\Command\ResizeImageCommand;
use App\Lab5\Editor\Command\SaveCommand;
use App\Lab5\Editor\Command\SetTitleCommand;
use App\Lab5\Editor\Document\Data\DocumentItemInterface;
use App\Lab5\Editor\Document\Data\ImageInterface;
use App\Lab5\Editor\Document\Data\ParagraphInterface;
use App\Lab5\Editor\Document\Exception\InvalidItemIndexException;
use App\Lab5\Editor\Document\History\History;
use App\Lab5\Editor\Utils\ImageService;

class Document implements DocumentInterface
{
    private History $history;

    /**
     * @var DocumentItemInterface[]
     */
    private array $items = [];

    private string $title = '';

    public function __construct()
    {
        $this->history = new History();
    }

    public function insertParagraph(string $content, ?int $position): void
    {
        $this->history->addAndExecuteCommand(
            new InsertParagraphCommand(
                $this->items,
                $content,
                $position,
            )
        );
    }

    public function insertImage(string $imageUrl, int $width, int $height, ?int $position = null): void
    {
        $this->history->addAndExecuteCommand(
            new InsertImageCommand(
                $this->items,
                $imageUrl,
                $width,
                $height,
                $position,
            ),
        );
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function replaceParagraphText(int $position, string $newText): void
    {
        $item = $this->items[$position] ?? null;
        if (is_null($item))
        {
            throw new InvalidItemIndexException();
        }

        if ($item instanceof ParagraphInterface)
        {
            $this->history->addAndExecuteCommand(
                new ReplaceTextCommand(
                    $item,
                    $newText,
                ),
            );
        }
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function resizeImage(int $position, int $newWidth, int $newHeight): void
    {
        $item = $this->items[$position] ?? null;
        if (is_null($item))
        {
            throw new InvalidItemIndexException();
        }

        if ($item instanceof ImageInterface)
        {
            $this->history->addAndExecuteCommand(
                new ResizeImageCommand(
                    $item,
                    $newWidth,
                    $newHeight,
                ),
            );
        }
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

    public function deleteItem(int $index): void
    {
        $this->history->addAndExecuteCommand(
            new DeleteItemCommand(
                $this->items,
                $index,
            )
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->history->addAndExecuteCommand(
            new SetTitleCommand(
                $this->title,
                $title,
            ),
        );
    }

    public function canUndo(): bool
    {
        return $this->history->canUndo();
    }

    public function undo(): void
    {
        $this->history->undo();
    }

    public function canRedo(): bool
    {
        return $this->history->canRedo();
    }

    public function redo(): void
    {
        $this->history->redo();
    }

    public function save(string $path): void
    {
        $this->history->addAndExecuteCommand(
            new SaveCommand(
                $this,
                $path,
            ),
        );
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
