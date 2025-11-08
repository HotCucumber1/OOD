<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Drawable;

use App\Lab7\Slide\Canvas\CanvasInterface;

interface DrawableInterface
{
    public function draw(CanvasInterface $canvas): void;
}