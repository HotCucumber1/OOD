<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Strategy;

use App\Lab1\Shapes\Common\Point;
use App\Lab1\Shapes\Entity\CanvasInterface;

class LineStrategy implements ShapeStrategyInterface
{
    private Point $start;
    private Point $end;

    public function __construct(
        float $x1,
        float $y1,
        float $x2,
        float $y2,
    )
    {
        $this->start = new Point($x1, $y1);
        $this->end = new Point($x2, $y2);
    }

    public function draw(CanvasInterface $canvas, string $hexColor): void
    {
        $canvas->setColor($hexColor);

        $canvas->moveTo(
            $this->start->x,
            $this->start->y,
        );
        $canvas->lineTo(
            $this->end->x,
            $this->end->y,
        );
    }

    public function move(float $dx, float $dy): void
    {
        $this->start->x += $dx;
        $this->start->y += $dy;

        $this->end->x += $dx;
        $this->end->y += $dy;
    }

    public function toString(): string
    {
        return 'line ' .
            $this->start->x . ' ' .
            $this->start->y . ' ' .
            $this->end->x . ' ' .
            $this->end->y;
    }
}