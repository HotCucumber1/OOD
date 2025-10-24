<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\Data\Paragraph;
use App\Lab5\Editor\Document\Exception\InvalidItemIndexException;

final class InsertParagraphCommand extends AbstractCommand
{
    public function __construct(
        private array           &$items,
        private readonly string $text,
        private ?int            $position = null,
    )
    {
    }

    /**
     * @throws InvalidItemIndexException
     */
    protected function doExecute(): void
    {
        $paragraph = new Paragraph($this->text);
        if (is_null($this->position))
        {
            $this->items[] = $paragraph;
            return;
        }
        if ($this->position >= count($this->items))
        {
            throw new InvalidItemIndexException();
        }
        array_splice($this->items, $this->position, 0, $paragraph);
    }

    protected function doUnexecute(): void
    {
        if (is_null($this->position))
        {
            $this->position = count($this->items) - 1;
        }
        unset($this->items[$this->position]);
    }
}