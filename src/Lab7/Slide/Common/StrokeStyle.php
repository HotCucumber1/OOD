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
}