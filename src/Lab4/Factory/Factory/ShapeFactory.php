<?php
declare(strict_types=1);

namespace App\Lab4\Factory\Factory;

use App\Lab4\Factory\Exception\ShapeNotFoundException;
use App\Lab4\Factory\Shapes\Ellipse;
use App\Lab4\Factory\Shapes\Rectangle;
use App\Lab4\Factory\Shapes\RegularPolygon;
use App\Lab4\Factory\Shapes\Shape;
use App\Lab4\Factory\Shapes\Triangle;
use App\Lab4\Factory\Utils\Color;
use App\Lab4\Factory\Utils\Point;

class ShapeFactory implements ShapeFactoryInterface
{
    private const int RECT_ARGS = 5;
    private const int TRIANGLE_ARGS = 7;
    private const int ELLIPSE_ARGS = 5;
    private const int POLYGON_ARGS = 6;

    /**
     * @throws ShapeNotFoundException
     */
    public function createShape(string $description): Shape
    {
        $args = explode(' ', $description);
        if (!isset($args[0]))
        {
            throw new ShapeNotFoundException();
        }
        $shapeArgs = array_slice($args, 1);

        return match ($args[0])
        {
            'rectangle' => self::createRect($shapeArgs),
            'triangle' => self::createTriangle($shapeArgs),
            'ellipse' => self::createEllipse($shapeArgs),
            'polygon' => self::createPolygon($shapeArgs),
            default => throw new ShapeNotFoundException(),
        };
    }

    /**
     * @param string[] $args
     */
    private static function createRect(array $args): Rectangle
    {
        self::assertArgsCount($args, self::RECT_ARGS);

        return new Rectangle(
            (int)$args[1],
            (int)$args[2],
            (int)$args[3],
            (int)$args[4],
            Color::from($args[0]),
        );
    }

    /**
     * @param string[] $args
     */
    private static function createTriangle(array $args): Triangle
    {
        self::assertArgsCount($args, self::TRIANGLE_ARGS);

        return new Triangle(
            (int)$args[1],
            (int)$args[2],
            (int)$args[3],
            (int)$args[4],
            (int)$args[5],
            (int)$args[6],
            Color::from($args[0]),
        );
    }

    /**
     * @param string[] $args
     */
    private static function createEllipse(array $args): Ellipse
    {
        self::assertArgsCount($args, self::ELLIPSE_ARGS);

        return new Ellipse(
            new Point((int)$args[1], (int)$args[2]),
            (int)$args[3],
            (int)$args[4],
            Color::from($args[0]),
        );
    }

    /**
     * @param string[] $args
     */
    private static function createPolygon(array $args): RegularPolygon
    {
        self::assertArgsCount($args, self::POLYGON_ARGS);

        $points = [];
        for ($i = 1; $i < count($args); $i += 2)
        {
            $points[] = new Point(
                (int)$args[$i],
                (int)$args[$i + 1],
            );
        }

        return new RegularPolygon(
            $points,
            Color::from($args[0]),
        );
    }

    /**
     * @param string[] $args
     */
    private static function assertArgsCount(array $args, int $count): void
    {
        if (count($args) < $count)
        {
            throw new \InvalidArgumentException('Wrong argument count');
        }
    }
}