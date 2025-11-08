<?php
declare(strict_types=1);

namespace Test\Unit\Slide\Mock;

use App\Lab7\Slide\Canvas\CanvasInterface;
use App\Lab7\Slide\Common\Point;

class MockCanvas implements CanvasInterface
{
    public function __construct(
        public int    $strokeWidth = 5,
        public string $strokeColor = '#AAAAAA',
        public string $fillColor = '#FFFFFF',
        public int    $lines = 0,
        public int    $strokeEllipse = 0,
        public int    $filledEllipse = 0,
        public int    $strokePolygon = 0,
        public int    $filledPolygon = 0,
    )
    {
    }


    public function drawLine(Point $start, Point $end): void
    {
        $this->lines++;
    }

    public function strokeEllipse(Point $center, int $rx, int $ry): void
    {
        $this->strokeEllipse++;
    }

    public function fillEllipse(Point $center, int $rx, int $ry): void
    {
        $this->filledEllipse++;
    }

    public function strokePolygon(array $points): void
    {
        $this->strokePolygon++;
    }

    public function fillPolygon(array $points): void
    {
        $this->filledPolygon++;
    }

    public function setFillColor(string $hex): void
    {
        $this->fillColor = $hex;
    }

    public function setStrokeColor(string $hex): void
    {
        $this->strokeColor = $hex;
    }

    public function setStrokeWidth(int $width): void
    {
        $this->strokeWidth = $width;
    }

    public function saveToFile(string $fileUrl): void
    {
    }
}