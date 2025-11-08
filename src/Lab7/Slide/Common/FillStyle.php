<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Common;

class FillStyle
{
    public function __construct(
        public string $hexColor,
        public bool  $isEnable,
    )
    {
    }

    public function __toString(): string
    {
        return $this->hexColor . ($this->isEnable ? 'true' : 'false');
    }
}