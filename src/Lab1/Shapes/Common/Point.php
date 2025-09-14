<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Common;

class Point
{
    public function __construct(
        public float $x,
        public float $y,
    )
    {
    }

    /**
     * @return array{int, int}
     */
    public function toArray(): array
    {
        return [
            $this->x,
            $this->y,
        ];
    }
}