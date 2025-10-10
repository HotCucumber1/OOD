<?php

namespace App\Lab4\Factory\Client;

use App\Lab4\Factory\Canvas\CanvasInterface;

class Painter
{
    public static function draw(PictureDraft $draft, CanvasInterface $canvas): void
    {
        foreach ($draft->getShapes() as $shape)
        {
            $shape->draw($canvas);
        }
    }
}