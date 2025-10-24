<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document;

use App\Lab5\Editor\Document\Data\DocumentItemInterface;

interface DocumentInterface
{
    public function insertParagraph(string $content, ?int $position): void;

    public function insertImage(string $imageUrl, int $width, int $height, ?int $position = null): void;

    public function replaceParagraphText(int $position, string $newText): void;

    public function resizeImage(int $position, int $newWidth, int $newHeight): void;

    public function getItemsCount(): int;

    public function getItem(int $index): DocumentItemInterface;

    /**
     * @return DocumentItemInterface[]
     */
    public function listItems(): array;

    public function deleteItem(int $index): void;

    public function getTitle(): string;

    public function setTitle(string $title): void;

    public function canUndo(): bool;

    public function undo(): void;

    public function canRedo(): bool;

    public function redo(): void;

    public function save(string $path): void;
}