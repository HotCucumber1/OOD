<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\Data;

class Image implements ImageInterface
{
    public function __construct(
        private readonly string $path,
        private int             $width,
        private int             $height,
    )
    {
    }

    public function getImage(): ?ImageInterface
    {
        return $this;
    }
    
    public function getParagraph(): ?ParagraphInterface
    {
        return null;
    }
    
    public function getHeight(): int
    {
        return $this->height;
    }
    
    public function getWidth(): int
    {
        return $this->width;
    }
    
    public function getPath(): string
    {
       return $this->path;
    }
    
    public function resize(int $width, int $height): void
    {
        $this->width = $width;
        $this->height = $height;
    }
}
