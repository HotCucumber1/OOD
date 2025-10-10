<?php
declare(strict_types=1);

namespace Test\Unit\FactoryShape;

use App\Lab4\Factory\Canvas\CanvasInterface;
use App\Lab4\Factory\Client\Painter;
use App\Lab4\Factory\Client\PictureDraft;
use App\Lab4\Factory\Shapes\Ellipse;
use App\Lab4\Factory\Shapes\Rectangle;
use App\Lab4\Factory\Shapes\RegularPolygon;
use App\Lab4\Factory\Shapes\Triangle;
use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;
use PHPUnit\Framework\TestCase;
use Test\Unit\FactoryShape\Mock\MockCanvas;

class PainterTest extends TestCase
{
    private CanvasInterface $canvas;

    protected function setUp(): void
    {
        parent::setUp();
        $this->canvas = new MockCanvas();
    }

    public function testDrawPictureSuccess(): void
    {
        $shapes = [
            new Ellipse(new Point(0, 0), 10, 10, Color::RED),
            new Rectangle(0, 0, 10, 10, Color::YELLOW),
            new RegularPolygon([new Point(1, 1), new Point(2, 2), new Point(3, 3)], Color::BLUE),
            new Triangle(1, 2, 3, 4, 5, 6, Color::WHITE),
        ];

        $draft = new PictureDraft($shapes);

        Painter::draw($draft, $this->canvas);

        self::assertEquals(1, $this->canvas->figureDrawn[MockCanvas::ELLIPSE]);
        self::assertEquals(10, $this->canvas->figureDrawn[MockCanvas::LINE]);
    }
}