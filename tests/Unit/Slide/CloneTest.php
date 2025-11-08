<?php
declare(strict_types=1);

namespace Test\Unit\Slide;

use App\Lab7\Slide\Common\FillStyle;
use App\Lab7\Slide\Common\Point;
use App\Lab7\Slide\Common\StrokeStyle;
use App\Lab7\Slide\Drawable\Ellipse;
use App\Lab7\Slide\Drawable\Rectangle;
use App\Lab7\Slide\Drawable\ShapeGroup;
use App\Lab7\Slide\Drawable\Triangle;
use App\Lab7\Slide\Exception\GroupMustContainAtLeastOneShapeException;
use PHPUnit\Framework\TestCase;

class CloneTest extends TestCase
{
    private FillStyle $defaultFillStyle;
    private StrokeStyle $defaultStrokeStyle;

    protected function setUp(): void
    {
        $this->defaultFillStyle = new FillStyle('#FFFFFF', true);
        $this->defaultStrokeStyle = new StrokeStyle('#000000', 5, true);
        parent::setUp();
    }

    public function testCloneRectangle(): void
    {
        $rect = new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle);
        $clone = $rect->clone();

        $clone->setFillStyle(new FillStyle('#000000', true));

        self::assertEquals($this->defaultFillStyle, $rect->getFillStyle());
    }

    public function testCloneTriangle(): void
    {
        $triangle = new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle);
        $clone = $triangle->clone();

        $clone->setFillStyle(new FillStyle('#000000', true));

        self::assertEquals($this->defaultFillStyle, $triangle->getFillStyle());
    }

    public function testCloneEllipse(): void
    {
        $ellipse = new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle);
        $clone = $ellipse->clone();

        $clone->setFillStyle(new FillStyle('#000000', true));

        self::assertEquals($this->defaultFillStyle, $ellipse->getFillStyle());
    }

    /**
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function testCloneGroup(): void
    {
        $shapes = [
            new Rectangle(1, 2, 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Triangle(1, 2, 3, 4, 5, 6, $this->defaultFillStyle, $this->defaultStrokeStyle),
            new Ellipse(new Point(1, 2), 3, 4, $this->defaultFillStyle, $this->defaultStrokeStyle),
        ];
        $group = new ShapeGroup($shapes);

        $clone = $group->clone();
        $clone->setFillStyle(new FillStyle('#QWERTY', true));

        foreach ($group->listElements() as $shape)
        {
            self::assertEquals($this->defaultFillStyle, $shape->getFillStyle());
        }
    }

}