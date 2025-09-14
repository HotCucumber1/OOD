<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Entity;

interface CanvasInterface
{
    public function draw(): void;

    public function moveTo(float $x, float $y): void;

    public function setColor(string $hexColor): void;

    public function lineTo(float $x, float $y): void;

    public function drawPolygon(): void;

    public function drawRect(float $left, float $top, float $width, float $height): void;

    public function drawEllipse(float $cx, float $cy, float $rx, float $ry): void;

    public function drawText(float $left, float $top, int $fontSize, string $text): void;
}