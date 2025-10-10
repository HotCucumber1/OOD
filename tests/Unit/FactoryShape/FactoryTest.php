<?php
declare(strict_types=1);

namespace Test\Unit\FactoryShape;

use App\Lab4\Factory\Exception\ShapeNotFoundException;
use App\Lab4\Factory\Factory\ShapeFactory;
use App\Lab4\Factory\Factory\ShapeFactoryInterface;
use App\Lab4\Factory\Shapes\Ellipse;
use App\Lab4\Factory\Shapes\Rectangle;
use App\Lab4\Factory\Shapes\RegularPolygon;
use App\Lab4\Factory\Shapes\Triangle;
use App\Lab4\Factory\Utils\Color;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    private ShapeFactoryInterface $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new ShapeFactory();
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function testCreateEllipseSuccess(): void
    {
        $ellipse = $this->factory->createShape('ellipse green 380 200 50 40');

        self::assertInstanceOf(Ellipse::class, $ellipse);
        self::assertEquals(380, $ellipse->center->x);
        self::assertEquals(Color::GREEN, $ellipse->getColor());
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function testCreateEllipseWithWrongArgumentCountFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->createShape('ellipse green 380 200 50');
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function testCreateRectSuccess(): void
    {
        $rect = $this->factory->createShape('rectangle blue 0 0 500 300');

        self::assertInstanceOf(Rectangle::class, $rect);
        self::assertEquals(500, $rect->width);
        self::assertEquals(Color::BLUE, $rect->getColor());
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function testCreateRectWithWrongArgumentCountFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->createShape('rectangle blue 0 0 500');
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function testCreatePolygonSuccess(): void
    {
        $poly = $this->factory->createShape('polygon black 150 200 350 200 250 100');

        self::assertInstanceOf(RegularPolygon::class, $poly);
        self::assertEquals(3, $poly->getVertexCount());
        self::assertEquals(Color::BLACK, $poly->getColor());
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function testCreatePolygonWithWrongArgumentCountFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->createShape('polygon black 150 200');
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function testCreateTriangleSuccess(): void
    {
        $poly = $this->factory->createShape('triangle black 150 200 350 200 250 100');

        self::assertInstanceOf(Triangle::class, $poly);
        self::assertCount(3, $poly->vertices);
        self::assertEquals(Color::BLACK, $poly->getColor());
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function testCreateTriangleWithWrongArgumentCountFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->createShape('triangle black 150 200');
    }


    public function testCreateShapeWithoutArgsFail(): void
    {
        $this->expectException(ShapeNotFoundException::class);
        $this->factory->createShape('');
    }

    public function testCreateNonExistedShapeFail(): void
    {
        $this->expectException(ShapeNotFoundException::class);
        $this->factory->createShape('pattern_factory');
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function testCreatShapeWithNonExistedColorFail(): void
    {
        $this->expectException(\ValueError::class);
        $this->factory->createShape('triangle magenta 150 200 350 200 250 100');
    }
}