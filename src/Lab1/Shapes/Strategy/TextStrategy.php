<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Strategy;

use App\Lab1\Shapes\Common\Point;
use App\Lab1\Shapes\Entity\CanvasInterface;

class TextStrategy implements ShapeStrategyInterface
{
    private Point $topLeft;

    public function __construct(
        float                   $leftX,
        float                   $topY,
        private readonly int    $fontSize,
        private readonly string $text,
    )
    {
        $this->topLeft = new Point($leftX, $topY);
    }

    public function draw(CanvasInterface $canvas, string $hexColor): void
    {
        $canvas->setColor($hexColor);

        $canvas->drawText(
            $this->topLeft->x,
            $this->topLeft->y,
            $this->fontSize,
            $this->text,
        );
    }

    public function move(float $dx, float $dy): void
    {
        $this->topLeft->x += $dx;
        $this->topLeft->y += $dy;
    }

    public function toString(): string
    {
        return 'text ' .
            $this->topLeft->x . ' ' .
            $this->topLeft->y . ' ' .
            $this->fontSize . ' ' .
            $this->text;
    }
}