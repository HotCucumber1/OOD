<?php

namespace App\Lab4\Factory\Shapes;

use App\Lab4\Factory\Canvas\CanvasInterface;
use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;

readonly class Ellipse extends Shape
{
    public function __construct(
        private(set) Point $center,
        private(set) int $rx,
        private(set) int $ry,
        Color  $color,
    )
    {
        parent::__construct($color);
    }

    protected function drawShape(CanvasInterface $canvas): void
    {
        $canvas->drawEllipse(
            $this->center->x,
            $this->center->y,
            $this->rx,
            $this->ry,
        );
    }
}