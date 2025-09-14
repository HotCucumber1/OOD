<?php
declare(strict_types=1);

namespace Test\Unit\Shape;

use App\Lab1\Shapes\Entity\CanvasInterface;
use App\Lab1\Shapes\Entity\Shape;
use App\Lab1\Shapes\Strategy\EllipseStrategy;
use App\Lab1\Shapes\Strategy\LineStrategy;
use App\Lab1\Shapes\Strategy\RectangleStrategy;
use App\Lab1\Shapes\Strategy\TextStrategy;
use App\Lab1\Shapes\Strategy\TriangleStrategy;
use PHPUnit\Framework\TestCase;
use Test\Unit\Shape\Mock\MockCanvas;

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
        $ellipse = new Shape(
            new EllipseStrategy(1, 2, 3, 4),
            'new color'
        );
        $ellipse->draw($this->canvas);

        self::assertEquals(1, $this->canvas->circleCount);
    }

    public function testMoveEllipseSuccess(): void
    {
        $ellipse = new Shape(
            new EllipseStrategy(1, 2, 3, 4),
            'new_color'
        );
        $ellipse->move(100, 100);

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals(1 + 100, (float)$ellipseInfo[2]);
        self::assertEquals(2 + 100, (float)$ellipseInfo[3]);
    }

    public function testSetEllipseColorSuccess(): void
    {
        $ellipse = new Shape(
            new EllipseStrategy(1, 2, 3, 4),
            'color'
        );
        $ellipse->setColor('color');

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals('color', $ellipseInfo[0]);
    }

    public function testDrawTriangleSuccess(): void
    {
        $ellipse = new Shape(
            new TriangleStrategy(1, 2, 3, 4, 5, 6),
            'new color'
        );
        $ellipse->draw($this->canvas);

        self::assertEquals(1, $this->canvas->triangleCount);
    }

    public function testMoveTriangleSuccess(): void
    {
        $ellipse = new Shape(
            new TriangleStrategy(1, 2, 3, 4, 5, 6),
            'new_color'
        );
        $ellipse->move(100, 100);

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals(1 + 100, (float)$ellipseInfo[2]);
        self::assertEquals(2 + 100, (float)$ellipseInfo[3]);
        self::assertEquals(3 + 100, (float)$ellipseInfo[4]);
        self::assertEquals(4 + 100, (float)$ellipseInfo[5]);
        self::assertEquals(5 + 100, (float)$ellipseInfo[6]);
        self::assertEquals(6 + 100, (float)$ellipseInfo[7]);
    }

    public function testSetTriangleColorSuccess(): void
    {
        $ellipse = new Shape(
            new TriangleStrategy(1, 2, 3, 4, 5, 6),
            'color'
        );
        $ellipse->setColor('color');

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals('color', $ellipseInfo[0]);
    }

    public function testDrawRectangleSuccess(): void
    {
        $ellipse = new Shape(
            new RectangleStrategy(1, 2, 3, 4),
            'new color'
        );
        $ellipse->draw($this->canvas);

        self::assertEquals(1, $this->canvas->rectCount);
    }

    public function testMoveRectangleSuccess(): void
    {
        $ellipse = new Shape(
            new RectangleStrategy(1, 2, 3, 4),
            'new_color'
        );
        $ellipse->move(100, 100);

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals(1 + 100, (float)$ellipseInfo[2]);
        self::assertEquals(2 + 100, (float)$ellipseInfo[3]);
    }

    public function testSetRectangleColorSuccess(): void
    {
        $ellipse = new Shape(
            new RectangleStrategy(1, 2, 3, 4),
            'color'
        );
        $ellipse->setColor('color');

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals('color', $ellipseInfo[0]);
    }

    public function testDrawLineSuccess(): void
    {
        $ellipse = new Shape(
            new LineStrategy(1, 2, 3, 4),
            'new color'
        );
        $ellipse->draw($this->canvas);

        self::assertEquals(1, $this->canvas->lineCount);
    }

    public function testMoveLineSuccess(): void
    {
        $ellipse = new Shape(
            new LineStrategy(1, 2, 3, 4),
            'new_color'
        );
        $ellipse->move(100, 100);

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals(1 + 100, (float)$ellipseInfo[2]);
        self::assertEquals(2 + 100, (float)$ellipseInfo[3]);
        self::assertEquals(3 + 100, (float)$ellipseInfo[4]);
        self::assertEquals(4 + 100, (float)$ellipseInfo[5]);
    }

    public function testSetLineColorSuccess(): void
    {
        $ellipse = new Shape(
            new LineStrategy(1, 2, 3, 4),
            'color'
        );
        $ellipse->setColor('color');

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals('color', $ellipseInfo[0]);
    }

    public function testDrawTextSuccess(): void
    {
        $ellipse = new Shape(
            new TextStrategy(1, 2, 3, 'Text'),
            'new color'
        );
        $ellipse->draw($this->canvas);

        self::assertEquals(1, $this->canvas->textCount);
    }

    public function testMoveTextSuccess(): void
    {
        $ellipse = new Shape(
            new TextStrategy(1, 2, 3, 'Text'),
            'new_color'
        );
        $ellipse->move(100, 100);

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals(1 + 100, (float)$ellipseInfo[2]);
        self::assertEquals(2 + 100, (float)$ellipseInfo[3]);
    }

    public function testSetTextColorSuccess(): void
    {
        $ellipse = new Shape(
            new TextStrategy(1, 2, 3, 'text'),
            'color'
        );
        $ellipse->setColor('color');

        $ellipseInfo = explode(' ', $ellipse->getInfo());
        self::assertEquals('color', $ellipseInfo[0]);
    }
}