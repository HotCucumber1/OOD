<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Drawable;

use App\Lab7\Slide\Canvas\CanvasInterface;
use App\Lab7\Slide\Common\FillStyle;
use App\Lab7\Slide\Common\Frame;
use App\Lab7\Slide\Common\StrokeStyle;

abstract class AbstractShape implements SlideComponentInterface
{
    public function __construct(
        protected Frame       $frame,
        protected StrokeStyle $strokeStyle,
        protected FillStyle   $fillStyle,
    )
    {
    }

    public function draw(CanvasInterface $canvas): void
    {
        if ($this->fillStyle->isEnable)
        {
            $canvas->setFillColor($this->fillStyle->hexColor);
        }
        if ($this->strokeStyle->isEnable)
        {
            $canvas->setStrokeColor($this->strokeStyle->hexColor);
            $canvas->setStrokeWidth($this->strokeStyle->width);
        }

        $this->doDraw($canvas);
    }

    public function getFrame(): Frame
    {
        return $this->frame;
    }

    public function getStrokeStyle(): ?StrokeStyle
    {
        return $this->strokeStyle;
    }

    public function setStrokeStyle(StrokeStyle $style): void
    {
        $this->strokeStyle = $style;
    }

    public function getFillStyle(): FillStyle
    {
        return $this->fillStyle;
    }

    public function setFillStyle(FillStyle $style): void
    {
        $this->fillStyle = $style;
    }

    final public function addComponent(SlideComponentInterface $component): void
    {
    }

    final public function getGroup(): ?ShapeGroup
    {
        return null;
    }

    abstract protected function doDraw(CanvasInterface $canvas): void;
}
