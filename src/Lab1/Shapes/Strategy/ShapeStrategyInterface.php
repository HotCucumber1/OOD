<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Strategy;

use App\Lab1\Shapes\Entity\CanvasInterface;

interface ShapeStrategyInterface
{
    public function draw(CanvasInterface $canvas, string $hexColor): void;

    public function move(float $dx, float $dy): void;

    public function toString(): string;
}