<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Strategy;

use App\Lab1\Shapes\Common\Point;
use App\Lab1\Shapes\Entity\CanvasInterface;

class EllipseStrategy implements ShapeStrategyInterface
{
    private Point $center;

    public function __construct(
        float                  $cx,
        float                  $cy,
        private readonly float $rx,
        private readonly float $ry,
    )
    {
        $this->center = new Point($cx, $cy);
    }

    public function draw(CanvasInterface $canvas, string $hexColor): void
    {
        $canvas->setColor($hexColor);

        $canvas->drawEllipse(
            $this->center->x,
            $this->center->y,
            $this->rx,
            $this->ry,
        );
    }

    public function move(float $dx, float $dy): void
    {
        $this->center->x += $dx;
        $this->center->y += $dy;
    }

    public function toString(): string
    {
        return 'circle ' .
            $this->center->x . ' ' .
            $this->center->y . ' ' .
            $this->rx . ' ' .
            $this->ry;
    }
}