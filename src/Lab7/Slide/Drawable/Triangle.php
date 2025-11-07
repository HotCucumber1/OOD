<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Drawable;

use App\Lab7\Slide\Canvas\CanvasInterface;
use App\Lab7\Slide\Common\FillStyle;
use App\Lab7\Slide\Common\Frame;
use App\Lab7\Slide\Common\Point;
use App\Lab7\Slide\Common\StrokeStyle;

class Triangle extends AbstractShape
{
    /**
     * @var Point[]
     */
    private array $points;

    public function __construct(
        int         $x1,
        int         $y1,
        int         $x2,
        int         $y2,
        int         $x3,
        int         $y3,
        FillStyle   $fillStyle,
        StrokeStyle $strokeStyle,
    )
    {
        $minX = min($x1, $x2, $x3);
        $maxX = max($x1, $x2, $x3);

        $minY = min($y1, $y2, $y3);
        $maxY = max($y1, $y2, $y3);

        $this->points = [
            new Point($x1, $y1),
            new Point($x2, $y2),
            new Point($x3, $y3),
        ];

        parent::__construct(
            new Frame($minX, $minY, $maxX, $maxY),
            $strokeStyle,
            $fillStyle,
        );
    }

    protected function doDraw(CanvasInterface $canvas): void
    {
        $canvas->fillPolygon($this->points);
        $canvas->strokePolygon($this->points);
    }

    public function setFrame(Frame $frame): void
    {
        $oldFrame = $this->frame;
        $this->points = array_map(static function (Point $point) use ($oldFrame, $frame) {
            return self::transformPoint($point, $oldFrame, $frame);
        }, $this->points);

        $this->frame = $frame;
    }

    private static function transformPoint(Point $point, Frame $oldFrame, Frame $newFrame): Point
    {
        $normalizedX = ($point->x - $oldFrame->topLeft->x) / $oldFrame->getWidth();
        $normalizedY = ($point->y - $oldFrame->topLeft->y) / $oldFrame->getHeight();

        $newX = $newFrame->topLeft->x + $normalizedX * $newFrame->getWidth();
        $newY = $newFrame->topLeft->y + $normalizedY * $newFrame->getHeight();

        return new Point((int)$newX, (int)$newY);
    }
}