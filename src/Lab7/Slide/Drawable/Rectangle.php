<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Drawable;

use App\Lab7\Slide\Canvas\CanvasInterface;
use App\Lab7\Slide\Common\FillStyle;
use App\Lab7\Slide\Common\Frame;
use App\Lab7\Slide\Common\Point;
use App\Lab7\Slide\Common\StrokeStyle;

class Rectangle extends AbstractShape
{
    public function __construct(
        int         $x1,
        int         $y1,
        int         $x2,
        int         $y2,
        FillStyle   $fillStyle,
        StrokeStyle $strokeStyle,
    )
    {
        parent::__construct(
            new Frame($x1, $y1, $x2, $y2),
            $strokeStyle,
            $fillStyle,
        );
    }

    public function doDraw(CanvasInterface $canvas): void
    {
        $points = [
            $this->frame->topLeft,
            new Point($this->frame->bottomRight->x, $this->frame->topLeft->y),
            $this->frame->bottomRight,
            new Point($this->frame->topLeft->x, $this->frame->bottomRight->y),
        ];

        $canvas->fillPolygon($points);
        $canvas->strokePolygon($points);
    }

    public function setFrame(Frame $frame): void
    {
        $this->frame = $frame;
    }
}