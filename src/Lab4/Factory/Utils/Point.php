<?php

namespace App\Lab4\Factory\Utils;

readonly class Point
{
    public function __construct(
        public int $x,
        public int $y,
    )
    {
    }
}