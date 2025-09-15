<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Entity;

use App\Lab1\Shapes\Strategy\ShapeStrategyInterface;

class Shape
{
    public function __construct(
        private ShapeStrategyInterface $shapeStrategy,
        private string                 $color = '#FFFFFF',
    )
    {
    }

    public function draw(CanvasInterface $canvas): void
    {
        $this->shapeStrategy->draw($canvas, $this->color);
    }

    public function move(float $dx, float $dy): void
    {
        $this->shapeStrategy->move($dx, $dy);
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function clone(): Shape
    {
        return clone $this;
    }

    public function setStrategy(ShapeStrategyInterface $shapeStrategy): void
    {
        $this->shapeStrategy = $shapeStrategy;
    }

    public function getInfo(): string
    {
        return $this->color . ' ' .
            $this->shapeStrategy->toString();
    }
}
