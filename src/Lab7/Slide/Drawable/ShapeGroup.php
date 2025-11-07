<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Drawable;

use App\Lab7\Slide\Canvas\CanvasInterface;
use App\Lab7\Slide\Common\FillStyle;
use App\Lab7\Slide\Common\Frame;
use App\Lab7\Slide\Common\StrokeStyle;
use App\Lab7\Slide\Exception\GroupMustContainAtLeastOneShapeException;

class ShapeGroup implements SlideComponentInterface
{
    /**
     * @param SlideComponentInterface[] $components
     * @throws GroupMustContainAtLeastOneShapeException
     */
    public function __construct(private array $components)
    {
        if (empty($this->components))
        {
            throw new GroupMustContainAtLeastOneShapeException();
        }
    }

    public function draw(CanvasInterface $canvas): void
    {
        foreach ($this->components as $shape)
        {
            $shape->draw($canvas);
        }
    }

    public function addComponent(SlideComponentInterface $component): void
    {
        $this->components[] = $component;
    }

    public function getFrame(): Frame
    {
        $minX = PHP_INT_MAX;
        $minY = PHP_INT_MAX;

        $maxX = PHP_INT_MIN;
        $maxY = PHP_INT_MIN;

        foreach ($this->components as $component)
        {
            $topLeft = $component->getFrame()->topLeft;
            $bottomRight = $component->getFrame()->bottomRight;

            if ($topLeft->x < $minX)
            {
                $minX = $topLeft->x;
            }
            if ($topLeft->y < $minY)
            {
                $minY = $topLeft->y;
            }
            if ($bottomRight->x > $maxX)
            {
                $maxX = $bottomRight->x;
            }
            if ($bottomRight->y > $maxY)
            {
                $maxY = $bottomRight->y;
            }
        }
        return new Frame($minX, $minY, $maxX, $maxY);
    }

    public function setFrame(Frame $frame): void
    {
        foreach ($this->components as $component)
        {
            $component->setFrame($frame);
        }
    }

    public function getStrokeStyle(): ?StrokeStyle
    {
        $styles = $this->getAllStrokeStyles();
        return self::getStyles($styles);
    }

    public function setStrokeStyle(StrokeStyle $style): void
    {
        foreach ($this->components as $component)
        {
            $component->setStrokeStyle($style);
        }
    }

    public function getFillStyle(): ?FillStyle
    {
        $styles = $this->getAllFillStyles();
        return self::getStyles($styles);
    }

    public function setFillStyle(FillStyle $style): void
    {
        foreach ($this->components as $component)
        {
            $component->setFillStyle($style);
        }
    }

    public function getGroup(): ?ShapeGroup
    {
        return $this;
    }

    private function getAllFillStyles(): array
    {
        return array_reduce($this->components, static function (array $acc, SlideComponentInterface $component): array {
            $acc[] = $component->getFillStyle();
            return $acc;
        }, []);
    }

    private function getAllStrokeStyles(): array
    {
        return array_reduce($this->components, static function (array $acc, SlideComponentInterface $component): array {
            $acc[] = $component->getStrokeStyle();
            return $acc;
        }, []);
    }

    /**
     * @param StrokeStyle[]|FillStyle[] $styles
     */
    private static function getStyles(array $styles): StrokeStyle|FillStyle|null
    {
        if (count(array_unique($styles)) > 1)
        {
            return null;
        }
        return $styles[0];
    }
}
