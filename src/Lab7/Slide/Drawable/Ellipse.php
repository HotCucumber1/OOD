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
        FillStyle     $fillStyle,
        StrokeStyle   $strokeStyle,
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
        $oldFrame = $this->getFrame();

        $scaleX = $frame->getWidth() / $oldFrame->getWidth();
        $scaleY = $frame->getHeight() / $oldFrame->getHeight();

        $this->rx = (int)($this->rx * $scaleX);
        $this->ry = (int)($this->ry * $scaleY);

        $newCenterX = $frame->topLeft->x + $frame->getWidth() / 2;
        $newCenterY = $frame->topLeft->y + $frame->getHeight() / 2;

        $this->center = new Point(
            (int)$newCenterX,
            (int)$newCenterY
        );

        $this->frame = $frame;
    }

    public function clone(): SlideComponentInterface
    {
        return new Ellipse(
            $this->center,
            $this->rx,
            $this->ry,
            $this->fillStyle,
            $this->strokeStyle,
        );
    }
}