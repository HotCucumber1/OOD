<?php

namespace App\Lab4\Factory\Canvas;


use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;

interface CanvasInterface
{
    public function setColor(Color $color): void;

    public function drawLine(Point $from, Point $to): void;

    public function drawEllipse(int $cx, int $cy, int $rx, int $ry): void;

    public function saveToFile(string $fileUrl): void;
}