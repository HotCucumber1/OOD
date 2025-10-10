<?php
declare(strict_types=1);

namespace Test\Unit\FactoryShape;

use App\Lab4\Factory\Client\Designer;
use App\Lab4\Factory\Exception\ShapeNotFoundException;
use App\Lab4\Factory\Factory\ShapeFactory;
use App\Lab4\Factory\Shapes\Ellipse;
use App\Lab4\Factory\Shapes\Rectangle;
use App\Lab4\Factory\Shapes\RegularPolygon;
use App\Lab4\Factory\Shapes\Triangle;
use PHPUnit\Framework\TestCase;

class DesignerTest extends TestCase
{
    /**
     * @throws ShapeNotFoundException
     */
    public function testGetDraftSuccess(): void
    {
        $factory = new ShapeFactory();
        $designer = new Designer($factory);

        $figures = "ellipse green 380 200 50 40'\nrectangle blue 0 0 500 300\npolygon black 150 200 350 200 250 100\ntriangle black 150 200 350 200 250 100";

        $input = fopen('php://memory', 'rb+');
        fwrite($input, $figures);
        rewind($input);

        $draft = $designer->createDraft($input);
        self::assertCount(4, $draft->getShapes());
        self::assertInstanceOf(Ellipse::class, $draft->getShape(0));
        self::assertInstanceOf(Rectangle::class, $draft->getShape(1));
        self::assertInstanceOf(RegularPolygon::class, $draft->getShape(2));
        self::assertInstanceOf(Triangle::class, $draft->getShape(3));
    }
}