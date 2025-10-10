<?php
declare(strict_types=1);

namespace App\Lab4\Factory\Utils;

use App\Lab4\Factory\Canvas\CanvasInterface;

abstract class PolygonDrawer
{
    /**
     * @param Point[] $vertices
     */
    public static function draw(array $vertices, CanvasInterface $canvas): void
    {
        for ($i = 0; $i < count($vertices); $i++)
        {
            $startPoint = $vertices[$i];
            $endPoint = $i === count($vertices) - 1
                ? $vertices[0]
                : $vertices[$i];

            $canvas->drawLine($startPoint, $endPoint);
        }
    }
}