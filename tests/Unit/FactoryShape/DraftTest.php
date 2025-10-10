<?php
declare(strict_types=1);

namespace Test\Unit\FactoryShape;

use App\Lab4\Factory\Client\PictureDraft;
use App\Lab4\Factory\Exception\ShapeNotFoundException;
use App\Lab4\Factory\Shapes\Ellipse;
use App\Lab4\Factory\Shapes\Rectangle;
use App\Lab4\Factory\Shapes\RegularPolygon;
use App\Lab4\Factory\Shapes\Triangle;
use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;
use PHPUnit\Framework\TestCase;

class DraftTest extends TestCase
{
    /**
     * @throws ShapeNotFoundException
     */
    public function testCreateDraftSuccess(): void
    {
        $shapes = [
            new Ellipse(new Point(0, 0), 10, 10, Color::RED),
            new Rectangle(0, 0, 10, 10, Color::YELLOW),
            new RegularPolygon([new Point(1, 1), new Point(2, 2), new Point(3, 3)], Color::BLUE),
            new Triangle(1, 2, 3, 4, 5, 6, Color::WHITE),
        ];

        $draft = new PictureDraft($shapes);

        self::assertCount(count($shapes), $draft->getShapes());
        self::assertInstanceOf(Ellipse::class, $draft->getShape(0));
        self::assertInstanceOf(Rectangle::class, $draft->getShape(1));
        self::assertInstanceOf(RegularPolygon::class, $draft->getShape(2));
        self::assertInstanceOf(Triangle::class, $draft->getShape(3));

        $this->expectException(ShapeNotFoundException::class);
        $draft->getShape(4);
    }
}