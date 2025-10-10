<?php
declare(strict_types=1);

namespace App\Lab4\Factory\Canvas;

use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;

class Canvas implements CanvasInterface
{
    private const int DEFAULT_THICKNESS = 4;
    private \GdImage $image;
    private int $color = 1;

    public function __construct()
    {
        $this->image = imagecreate(500, 500);
        imagesetthickness($this->image, self::DEFAULT_THICKNESS);
    }

    public function setColor(Color $color): void
    {
        $this->color = match ($color) {
            Color::GREEN => imagecolorallocate($this->image, 0, 128, 0),
            Color::RED => imagecolorallocate($this->image, 255, 0, 0),
            Color::BLUE => imagecolorallocate($this->image, 0, 0, 255),
            Color::YELLOW => imagecolorallocate($this->image, 255, 255, 0),
            Color::PINK => imagecolorallocate($this->image, 255, 192, 203),
            Color::BLACK => imagecolorallocate($this->image, 0, 0, 0),
            Color::WHITE => imagecolorallocate($this->image, 255, 255, 255),
        };
    }

    public function drawLine(Point $from, Point $to): void
    {
        imageline(
            $this->image,
            $from->x,
            $from->y,
            $to->x,
            $to->y,
            $this->color,
        );
    }

    public function drawEllipse(int $cx, int $cy, int $rx, int $ry): void
    {
        imagefilledellipse(
            $this->image,
            $cx,
            $cy,
            $rx,
            $ry,
            $this->color,
        );
    }

    public function saveToFile(string $fileUrl): void
    {
        imagepng($this->image, $fileUrl);
        imagedestroy($this->image);
    }
}