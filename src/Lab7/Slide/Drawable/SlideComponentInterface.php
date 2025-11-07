<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Drawable;

use App\Lab7\Slide\Common\FillStyle;
use App\Lab7\Slide\Common\Frame;
use App\Lab7\Slide\Common\StrokeStyle;

interface SlideComponentInterface extends DrawableInterface
{
    public function getFrame(): Frame;

    public function setFrame(Frame $frame): void;

    public function getStrokeStyle(): ?StrokeStyle;

    public function setStrokeStyle(StrokeStyle $style): void;

    public function getFillStyle(): ?FillStyle;

    public function setFillStyle(FillStyle $style): void;

    public function getGroup(): ?ShapeGroup;
}