<?php

namespace App\Lab4\Factory\Shapes;

use App\Lab4\Factory\Canvas\CanvasInterface;
use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;
use App\Lab4\Factory\Utils\PolygonDrawer;

readonly class Triangle extends Shape
{
    /**
     * @var Point[]
     */
    private(set) array $vertices;

    public function __construct(
        int   $x1,
        int   $y1,
        int   $x2,
        int   $y2,
        int   $x3,
        int   $y3,
        Color $color,
    )
    {
        parent::__construct($color);
        $this->vertices = [
            new Point($x1, $y1),
            new Point($x2, $y2),
            new Point($x3, $y3),
        ];
    }

    protected function drawShape(CanvasInterface $canvas): void
    {
        PolygonDrawer::draw($this->vertices, $canvas);
    }
}