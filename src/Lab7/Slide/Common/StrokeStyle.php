<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Common;

class StrokeStyle
{
    public function __construct(
        public string $hexColor,
        public int    $width,
        public bool   $isEnable,
    )
    {
    }

    public function __toString(): string
    {
        return $this->hexColor . ($this->isEnable ? 'true' : 'false') . $this->width;
    }
}