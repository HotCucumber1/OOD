<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Common;

use App\Lab7\Slide\Drawable\SlideComponentInterface;

interface GroupInterface
{
    public function addComponent(SlideComponentInterface $component): void;
}