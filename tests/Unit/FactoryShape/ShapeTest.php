<?php
declare(strict_types=1);

namespace Test\Unit\FactoryShape;

use App\Lab4\Factory\Canvas\CanvasInterface;
use App\Lab4\Factory\Shapes\Ellipse;
use App\Lab4\Factory\Shapes\Rectangle;
use App\Lab4\Factory\Shapes\RegularPolygon;
use App\Lab4\Factory\Shapes\Triangle;
use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;
use PHPUnit\Framework\TestCase;
use Test\Unit\FactoryShape\Mock\MockCanvas;

class ShapeTest extends TestCase
{
    private CanvasInterface $canvas;

    protected function setUp(): void
    {
        parent::setUp();
        $this->canvas = new MockCanvas();
    }

    public function testDrawEllipseSuccess(): void
    {
        $ellipse = new Ellipse(
            new Point(0, 0),
            10,
            10,
            Color::BLACK,
        );
        $ellipse->draw($this->canvas);

        self::assertEquals(1, $this->canvas->figureDrawn[MockCanvas::ELLIPSE]);
    }

    public function testDrawRectSuccess(): void
    {
        $rect = new Rectangle(
            10, 10,
            20, 20,
            Color::BLACK,
        );
        $rect->draw($this->canvas);

        self::assertEquals(4, $this->canvas->figureDrawn[MockCanvas::LINE]);
    }

    public function testDrawPolygonSuccess(): void
    {
        $polygon = new RegularPolygon([
            new Point(10, 10),
            new Point(10, 30),
            new Point(20, 40),
            new Point(50, 40),
            new Point(20, 10),
            new Point(10, 10),
        ], Color::RED);
        $polygon->draw($this->canvas);

        self::assertEquals(6, $this->canvas->figureDrawn[MockCanvas::LINE]);
    }

    public function testDrawTriangleSuccess(): void
    {
        $triangle = new Triangle(10, 10, 20, 20, 30, 10, Color::GREEN);
        $triangle->draw($this->canvas);

        self::assertEquals(3, $this->canvas->figureDrawn[MockCanvas::LINE]);
    }
}