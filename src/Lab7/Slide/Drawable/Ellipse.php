<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Drawable;


use App\Lab7\Slide\Canvas\CanvasInterface;
use App\Lab7\Slide\Common\FillStyle;
use App\Lab7\Slide\Common\Frame;
use App\Lab7\Slide\Common\Point;
use App\Lab7\Slide\Common\StrokeStyle;

class Ellipse extends AbstractShape
{
    public function __construct(
        private Point $center,
        private int   $rx,
        private int   $ry,
        StrokeStyle   $strokeStyle,
        FillStyle     $fillStyle,
    )
    {
        parent::__construct(
            new Frame(
                $this->center->x - $this->rx,
                $this->center->y - $this->ry,
                $this->center->x + $this->rx,
                $this->center->y + $this->ry,
            ),
            $strokeStyle,
            $fillStyle,
        );
    }

    protected function doDraw(CanvasInterface $canvas): void
    {
        $canvas->fillEllipse($this->center, $this->rx, $this->ry);
        $canvas->strokeEllipse($this->center, $this->rx, $this->ry);
    }

    public function setFrame(Frame $frame): void
    {
        $this->frame = $frame;
        $this->rx = $frame->getWidth() / 2;
        $this->ry = $frame->getHeight() / 2;

        $this->center = new Point(
            $frame->topLeft->x + $this->rx,
            $frame->topLeft->y + $this->ry,
        );
    }
}