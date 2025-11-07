<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Common;

class Point
{
    public function __construct(
        public int $x,
        public int $y,
    )
    {
    }
}