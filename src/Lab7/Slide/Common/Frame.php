<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Common;

class Frame
{
    public Point $topLeft {
        get {
            return $this->topLeft;
        }
        set(Point $value) {
            $this->topLeft = $value;
        }
    }
    public Point $bottomRight {
        get {
            return $this->bottomRight;
        }
        set(Point $value) {
            $this->bottomRight = $value;
        }
    }

    public function __construct(int $x1, int $y1, int $x2, int $y2)
    {
        $this->topLeft = new Point($x1, $y1);
        $this->bottomRight = new Point($x2, $y2);
    }

    public function getWidth(): int
    {
        return abs($this->bottomRight->x - $this->topLeft->x);
    }

    public function getHeight(): int
    {
        return abs($this->topLeft->y - $this->bottomRight->y);
    }
}