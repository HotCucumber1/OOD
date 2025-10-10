<?php
declare(strict_types=1);

namespace Test\Unit\FactoryShape\Mock;

use App\Lab4\Factory\Canvas\CanvasInterface;
use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;

class MockCanvas implements CanvasInterface
{
    public const string LINE = 'line';
    public const string ELLIPSE = 'ellipse';

    private(set) array $figureDrawn = [
        self::LINE => 0,
        self::ELLIPSE => 0,
    ];

    public function __construct(
        private(set) Color $color = Color::GREEN,
    )
    {
    }

    public function setColor(Color $color): void
    {
        $this->color = $color;
    }

    public function drawLine(Point $from, Point $to): void
    {
        ++$this->figureDrawn[self::LINE];
    }

    public function drawEllipse(int $cx, int $cy, int $rx, int $ry): void
    {
        ++$this->figureDrawn[self::ELLIPSE];
    }

    public function saveToFile(string $fileUrl): void
    {
    }
}