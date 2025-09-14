<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Strategy;

use App\Lab1\Shapes\Common\Point;
use App\Lab1\Shapes\Entity\CanvasInterface;

class TriangleStrategy implements ShapeStrategyInterface
{
    /**
     * @var Point[]
     */
    private array $vertices;

    public function __construct(
        float $x1,
        float $y1,
        float $x2,
        float $y2,
        float $x3,
        float $y3,
    )
    {
        $this->vertices = [
            new Point($x1, $y1),
            new Point($x2, $y2),
            new Point($x3, $y3),
        ];
    }

    public function draw(CanvasInterface $canvas, string $hexColor): void
    {
        $canvas->setColor($hexColor);

        $canvas->moveTo(
            $this->vertices[0]->x,
            $this->vertices[0]->y,
        );

        for ($i = 0; $i < count($this->vertices); $i++)
        {
            $canvas->lineTo(
                $this->vertices[$i]->x,
                $this->vertices[$i]->y,
            );
        }
        $canvas->drawPolygon();
    }

    public function move(float $dx, float $dy): void
    {
        foreach ($this->vertices as $vertex)
        {
            $vertex->x += $dx;
            $vertex->y += $dy;
        }
    }

    public function toString(): string
    {
        $info =  'triangle';
        
        return array_reduce($this->vertices, static function ($acc, Point $point): string {
            return $acc . ' ' .
                $point->x . ' ' .
                $point->y;
        }, $info);
    }
}