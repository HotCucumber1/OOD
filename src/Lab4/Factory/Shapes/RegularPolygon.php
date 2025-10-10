<?php

namespace App\Lab4\Factory\Shapes;

use App\Lab4\Factory\Canvas\CanvasInterface;
use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;
use App\Lab4\Factory\Utils\PolygonDrawer;

readonly class RegularPolygon extends Shape
{
    /**
     * @param Point[] $vertices
     */
    public function __construct(
        private array $vertices,
        Color         $color,
    )
    {
        parent::__construct($color);
    }

    public function getVertexCount(): int
    {
        return count($this->vertices);
    }

    protected function drawShape(CanvasInterface $canvas): void
    {
        PolygonDrawer::draw($this->vertices, $canvas);
    }
}