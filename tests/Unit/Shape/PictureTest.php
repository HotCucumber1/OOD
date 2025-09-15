<?php
declare(strict_types=1);

namespace Test\Unit\Shape;

use App\Lab1\Shapes\Entity\CanvasInterface;
use App\Lab1\Shapes\Entity\Picture;
use App\Lab1\Shapes\Entity\Shape;
use App\Lab1\Shapes\Exception\ShapeAlreadyExistsException;
use App\Lab1\Shapes\Exception\ShapeNotFoundException;
use App\Lab1\Shapes\Strategy\EllipseStrategy;
use App\Lab1\Shapes\Strategy\LineStrategy;
use App\Lab1\Shapes\Strategy\RectangleStrategy;
use App\Lab1\Shapes\Strategy\TextStrategy;
use App\Lab1\Shapes\Strategy\TriangleStrategy;
use PHPUnit\Framework\TestCase;
use Test\Unit\Shape\Mock\MockCanvas;

class PictureTest extends TestCase
{
    private CanvasInterface $canvas;
    private Picture $picture;

    protected function setUp(): void
    {
        parent::setUp();
        $this->canvas = new MockCanvas();
        $this->picture = new Picture($this->canvas);
    }

    /**
     * @throws ShapeAlreadyExistsException
     * @throws ShapeNotFoundException
     */
    public function testStoreShapeSuccess(): void
    {
        $this->picture->storeShape('new_shape', self::getLine());

        $this->picture->findShape('new_shape');
        self::assertTrue(true);
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    public function testStoreExistedShapeFail(): void
    {
        $this->picture->storeShape('new_shape', self::getLine());

        $this->expectException(ShapeAlreadyExistsException::class);
        $this->picture->storeShape('new_shape', self::getLine());
    }

    /**
     * @throws ShapeNotFoundException
     * @throws ShapeAlreadyExistsException
     */
    public function testDeleteShapeSuccess(): void
    {
        $this->picture->storeShape('new_shape', self::getLine());

        $this->picture->deleteShape('new_shape');
        self::assertEmpty($this->picture->listShapes());
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    public function testDeleteNonExistedShapeSuccess(): void
    {
        $this->picture->storeShape('new_shape', self::getLine());

        $this->expectException(ShapeNotFoundException::class);
        $this->picture->deleteShape('new_shape1');
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    public function testListShapesSuccess(): void
    {
        $this->picture->storeShape('new_shape1', self::getLine());
        $this->picture->storeShape('new_shape2', self::getLine());

        $shapes = $this->picture->listShapes();
        self::assertCount(2, $shapes);
    }

    public function testListEmptyShapesSuccess(): void
    {
        $shapes = $this->picture->listShapes();
        self::assertEmpty($shapes);
    }

    /**
     * @throws ShapeNotFoundException
     * @throws ShapeAlreadyExistsException
     */
    public function testFindShapeSuccess(): void
    {
        $this->picture->storeShape('new_shape1', self::getLine());
        $this->picture->storeShape('new_shape2', self::getLine());

        $this->picture->findShape('new_shape2');
        self::assertTrue(true);
    }

    /**
     * @throws ShapeNotFoundException
     * @throws ShapeAlreadyExistsException
     */
    public function testDrawShapeSuccess(): void
    {
        $this->picture->storeShape('new_shape1', self::getLine());

        $this->picture->drawShape('new_shape1');
        self::assertEquals(1, $this->canvas->lineCount);
    }

    /**
     * @throws ShapeNotFoundException
     * @throws ShapeAlreadyExistsException
     */
    public function testCloneShapeSuccess(): void
    {
        $this->picture->storeShape('new_shape1', self::getLine());
        $this->picture->cloneShape('new_shape1', 'cloned_shape');

        $this->picture->findShape('cloned_shape');
        self::assertTrue(true);

        $shapes = $this->picture->listShapes();
        self::assertCount(2, $shapes);
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    public function testCloneShapeWithNoExistedIdFail(): void
    {
        $this->picture->storeShape('new_shape1', self::getLine());

        $this->expectException(ShapeNotFoundException::class);
        $this->picture->cloneShape('new_shape100500', 'cloned_shape');
    }

    /**
     * @throws ShapeNotFoundException
     * @throws ShapeAlreadyExistsException
     */
    public function testCloneShapeWithNewIdThatAlreadyExistFail(): void
    {
        $this->picture->storeShape('new_shape1', self::getLine());
        $this->picture->storeShape('new_shape2', self::getLine());

        $this->expectException(ShapeAlreadyExistsException::class);
        $this->picture->cloneShape('new_shape1', 'new_shape2');
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    public function testDrawAllShapesSuccess(): void
    {
        $this->picture->storeShape('new_shape1', self::getLine());
        $this->picture->storeShape('new_shape2', self::getRect());
        $this->picture->storeShape('new_shape3', self::getEllipse());
        $this->picture->storeShape('new_shape4', self::getText());
        $this->picture->storeShape('new_shape5', self::getTriangle());

        $this->picture->draw();
        self::assertEquals(1 + 3, $this->canvas->lineCount);
        self::assertEquals(1, $this->canvas->rectCount);
        self::assertEquals(1, $this->canvas->circleCount);
        self::assertEquals(1, $this->canvas->textCount);
        self::assertEquals(1, $this->canvas->triangleCount);
    }

    /**
     * @throws ShapeAlreadyExistsException
     * @throws ShapeNotFoundException
     */
    public function testShapesAreNotDrawAfterDeleteSuccess(): void
    {
        $this->picture->storeShape('new_shape2', self::getRect());
        $this->picture->storeShape('new_shape3', self::getEllipse());

        $this->picture->draw();
        self::assertEquals(1, $this->canvas->rectCount);
        self::assertEquals(1, $this->canvas->circleCount);

        $this->picture->deleteShape('new_shape3');
        $this->picture->draw();

        self::assertEquals(2, $this->canvas->rectCount);
        self::assertEquals(1, $this->canvas->circleCount);
    }

    private static function getRect(): Shape
    {
        return new Shape(
            new RectangleStrategy(1, 2, 3, 4),
            'color'
        );
    }

    private static function getEllipse(): Shape
    {
        return new Shape(
            new EllipseStrategy(1, 2, 3, 4),
            'color'
        );
    }

    private static function getLine(): Shape
    {
        return new Shape(
            new LineStrategy(1, 2, 3, 4),
            'new color'
        );
    }

    private static function getText(): Shape
    {
        return new Shape(
            new TextStrategy(1, 2, 3, 'Text'),
            'new color'
        );
    }

    private static function getTriangle(): Shape
    {
        return new Shape(
            new TriangleStrategy(1, 2, 3, 4, 5, 6),
            'color'
        );
    }
}