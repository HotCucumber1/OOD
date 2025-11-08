<?php
declare(strict_types=1);

namespace Test\Unit\Slide;

use App\Lab7\Slide\Canvas\CanvasInterface;
use App\Lab7\Slide\Common\FillStyle;
use App\Lab7\Slide\Common\Frame;
use App\Lab7\Slide\Common\Point;
use App\Lab7\Slide\Common\StrokeStyle;
use App\Lab7\Slide\Drawable\Ellipse;
use App\Lab7\Slide\Drawable\Rectangle;
use App\Lab7\Slide\Drawable\ShapeGroup;
use App\Lab7\Slide\Drawable\Triangle;
use App\Lab7\Slide\Exception\GroupMustContainAtLeastOneShapeException;
use PHPUnit\Framework\TestCase;
use Test\Unit\Slide\Mock\MockCanvas;

class ShapeGroupTest extends TestCase
{
    private CanvasInterface $canvas;
    private FillStyle $defaultFillStyle;
    private StrokeStyle $defaultStrokeStyle;

    protected function setUp(): void
    {
        $this->canvas = new MockCanvas();
        $this->defaultFillStyle = new FillStyle('#FFFFFF', true);
        $this->defaultStrokeStyle = new StrokeStyle('#000000', 5, true);
        parent::setUp();
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testCreateGroupSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
        ];

        $group = new ShapeGroup($shapes);
        $groupShapes = $group->listElements();

        self::assertEquals($shapes, $groupShapes);
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testCreateRecursiveGroupSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
        ];
        $shapesWithGroup = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new ShapeGroup($shapes),
        ];

        $group = new ShapeGroup($shapesWithGroup);
        $groupShapes = $group->listElements();

        self::assertEquals($shapesWithGroup, $groupShapes);
    }

    public function testCreateEmptyGroupFail(): void
    {
        $this->expectException(GroupMustContainAtLeastOneShapeException::class);
        new ShapeGroup([]);
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testDrawShapesSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
        ];
        $shapesWithGroup = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new ShapeGroup($shapes),
        ];

        $group = new ShapeGroup($shapesWithGroup);
        $group->draw($this->canvas);

        self::assertEquals(4, $this->canvas->filledPolygon);
        self::assertEquals(2, $this->canvas->filledEllipse);
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testAddComponentsSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
        ];

        $group = new ShapeGroup($shapes);
        $group->addComponent(
            new Rectangle(5, 6, 7, 8, $this->defaultFillStyle, $this->defaultStrokeStyle),
        );
        self::assertCount(4, $group->listElements());
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testGetTotalStrokeStyleSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
        ];

        $group = new ShapeGroup($shapes);
        $strokeStyle = $group->getStrokeStyle();

        self::assertEquals($this->defaultStrokeStyle, $strokeStyle);
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testGetDifferentStrokeStyleSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, new StrokeStyle('#AAAAAA', 10, false)),
        ];

        $group = new ShapeGroup($shapes);
        $strokeStyle = $group->getStrokeStyle();

        self::assertNull($strokeStyle);
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testGetTotalFillStyleSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
        ];

        $group = new ShapeGroup($shapes);
        $fillStyle = $group->getFillStyle();

        self::assertEquals($this->defaultFillStyle, $fillStyle);
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testGetDifferentFillStyleSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, new FillStyle('#AAAAAA', false), $this->defaultStrokeStyle),
        ];

        $group = new ShapeGroup($shapes);
        $fillStyle = $group->getFillStyle();

        self::assertNull($fillStyle);
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testSetFillStyleSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, new FillStyle('#QWERTY', true), $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6,  new FillStyle('#HAHAHA', true), $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, new FillStyle('#AAAAAA', false), $this->defaultStrokeStyle),
        ];
        $group = new ShapeGroup($shapes);
        $group->setFillStyle($this->defaultFillStyle);

        $fillStyle = $group->getFillStyle();
        self::assertEquals($this->defaultFillStyle, $fillStyle);
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testSetStrokeStyleSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, new StrokeStyle('#QWERTY', 5, true)),
            new Triangle(1, 2, 3, 4, 5, 6,  $this->defaultFillStyle, new StrokeStyle('#Q12345', 15, false)),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, new StrokeStyle('#HEHEHE', 1, true)),
        ];
        $group = new ShapeGroup($shapes);
        $group->setStrokeStyle($this->defaultStrokeStyle);

        $strokeStyle = $group->getStrokeStyle();
        self::assertEquals($this->defaultStrokeStyle, $strokeStyle);
    }


    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testGetGroupFrameSuccess(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, new StrokeStyle('#QWERTY', 5, true)),
            new Triangle(5, 6, 7, 8, 9, 10,  $this->defaultFillStyle, new StrokeStyle('#Q12345', 15, false)),
            new Ellipse(new Point(2, 2), 2, 2, $this->defaultFillStyle, new StrokeStyle('#HEHEHE', 1, true)),
        ];

        $group = new ShapeGroup($shapes);
        $frame = $group->getFrame();

        self::assertEquals(0, $frame->topLeft->x);
        self::assertEquals(0, $frame->topLeft->y);

        self::assertEquals(9, $frame->bottomRight->x);
        self::assertEquals(10, $frame->bottomRight->y);
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testSetGroupFrameSuccess(): void
    {
        $shapes = [
            new Rectangle(0, 0, 10, 10, $this->defaultFillStyle, new StrokeStyle('#QWERTY', 5, true)),
            new Triangle(0, 0, 10, 10, 5, 10,  $this->defaultFillStyle, new StrokeStyle('#Q12345', 15, false)),
            new Ellipse(new Point(5, 5), 5, 5, $this->defaultFillStyle, new StrokeStyle('#HEHEHE', 1, true)),
        ];

        $group = new ShapeGroup($shapes);
        $group->setFrame(new Frame(0, 0, 100, 100));

        $shapes = $group->listElements();
        foreach ($shapes as $shape)
        {
            self::assertEquals(100, $shape->getFrame()->bottomRight->x);
            self::assertEquals(100, $shape->getFrame()->bottomRight->y);
        }
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testGetGroupSuccess(): void
    {
        $shapes = [
            new Rectangle(0, 0, 10, 10, $this->defaultFillStyle, new StrokeStyle('#QWERTY', 5, true)),
            new Triangle(0, 0, 10, 10, 5, 10,  $this->defaultFillStyle, new StrokeStyle('#Q12345', 15, false)),
            new Ellipse(new Point(5, 5), 5, 5, $this->defaultFillStyle, new StrokeStyle('#HEHEHE', 1, true)),
        ];

        $group = new ShapeGroup($shapes);

        $groupCopy = $group->getGroup();
        self::assertSame($group, $groupCopy);
    }

    public function testGetGroupFail(): void
    {
        $shape = new Rectangle(0, 0, 10, 10, $this->defaultFillStyle, new StrokeStyle('#QWERTY', 5, true));

        $groupCopy = $shape->getGroup();
        self::assertNull($groupCopy);
    }
}