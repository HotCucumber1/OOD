<?php
declare(strict_types=1);

namespace Test\Unit\Shape\Mock;

use App\Lab1\Shapes\Entity\CanvasInterface;

class MockCanvas implements CanvasInterface
{
    public int $rectCount = 0;
    public int $circleCount = 0;
    public int $triangleCount = 0;
    public int $textCount = 0;
    public int $lineCount = 0;
    public string $color = 'color';

    public function draw(): void
    {
    }

    public function moveTo(float $x, float $y): void
    {
    }

    public function lineTo(float $x, float $y): void
    {
        $this->lineCount++;
    }

    public function setColor(string $hexColor): void
    {
        $this->color = $hexColor;
    }

    public function drawPolygon(): void
    {
        $this->triangleCount++;
    }

    public function drawEllipse(float $cx, float $cy, float $rx, float $ry): void
    {
        $this->circleCount++;
    }

    public function drawText(float $left, float $top, int $fontSize, string $text): void
    {
        $this->textCount++;
    }

    public function drawRect(float $left, float $top, float $width, float $height): void
    {
        $this->rectCount++;
    }
}