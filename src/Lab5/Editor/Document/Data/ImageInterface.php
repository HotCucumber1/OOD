<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\Data;

interface ImageInterface extends DocumentItemInterface
{
    public function getPath(): string;

    public function getWidth(): int;

    public function getHeight(): int;

    public function resize(int $width, int $height): void;
}