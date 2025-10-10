<?php
declare(strict_types=1);

namespace App\Lab4\Factory\Shapes;

use App\Lab4\Factory\Canvas\CanvasInterface;
use App\Lab4\Factory\Utils\Color;

abstract readonly class Shape
{
    public function __construct(
        private Color $color,
    )
    {
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    public function draw(CanvasInterface $canvas): void
    {
        $canvas->setColor($this->getColor());
        $this->drawShape($canvas);
    }

    abstract protected function drawShape(CanvasInterface $canvas): void;
}