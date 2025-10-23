<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\Data;

class Paragraph implements ParagraphInterface
{
    public function __construct(
        private string $text,
    )
    {
    }

    public function getParagraph(): ?ParagraphInterface
    {
        return $this;
    }

    public function getImage(): ?ImageInterface
    {
        return null;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}