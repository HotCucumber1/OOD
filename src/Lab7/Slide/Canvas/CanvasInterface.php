<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Canvas;

use App\Lab7\Slide\Common\Point;

interface CanvasInterface
{
    public function drawLine(Point $start, Point $end): void;

    public function strokeEllipse(Point $center, int $rx, int $ry): void;

    public function fillEllipse(Point $center, int $rx, int $ry): void;

    /**
     * @param Point[] $points
     */
    public function strokePolygon(array $points): void;

    /**
     * @param Point[] $points
     */
    public function fillPolygon(array $points): void;

    public function setFillColor(string $hex): void;

    public function setStrokeColor(string $hex): void;

    public function setStrokeWidth(int $width): void;

    public function saveToFile(string $fileUrl): void;
}