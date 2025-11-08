<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Drawable;

use App\Lab7\Slide\Canvas\CanvasInterface;
use App\Lab7\Slide\Common\GroupInterface;

class Slide implements DrawableInterface, GroupInterface
{
    /**
     * @param SlideComponentInterface[] $shapes
     */
    public function __construct(
        private array $shapes = [],
    )
    {
    }

    public function draw(CanvasInterface $canvas): void
    {
        foreach ($this->shapes as $shape)
        {
            $shape->draw($canvas);
        }
    }

    public function addComponent(SlideComponentInterface $component): void
    {
        $this->shapes[] = $component;
    }
}