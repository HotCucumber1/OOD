<?php

namespace App\Lab4\Factory\Shapes;

use App\Lab4\Factory\Canvas\CanvasInterface;
use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;
use App\Lab4\Factory\Utils\PolygonDrawer;

readonly class Rectangle extends Shape
{
    public function __construct(
        private(set) int $x,
        private(set) int $y,
        private(set) int $width,
        private(set) int $height,
        Color  $color,
    )
    {
        parent::__construct($color);
    }

    protected function drawShape(CanvasInterface $canvas): void
    {
        $points = $this->getRectPoints();
        PolygonDrawer::draw($points, $canvas);
    }

    /**
     * @return Point[]
     */
    private function getRectPoints(): array
    {
        return [
            new Point($this->x, $this->y),
            new Point($this->x + $this->width, $this->y),
            new Point($this->x + $this->width, $this->y + $this->height),
            new Point($this->x, $this->y + $this->height),
        ];
    }
}