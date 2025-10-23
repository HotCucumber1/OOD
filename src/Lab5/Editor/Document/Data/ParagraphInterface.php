<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\Data;

interface ParagraphInterface extends DocumentItemInterface
{
    public function getText(): string;

    public function setText(string $text): void;
}