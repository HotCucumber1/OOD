<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\Data;

interface DocumentItemInterface
{
    public function getImage(): ?ImageInterface;

    public function getParagraph(): ?ParagraphInterface;
}