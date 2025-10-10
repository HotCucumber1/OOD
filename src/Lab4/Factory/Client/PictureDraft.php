<?php

namespace App\Lab4\Factory\Client;

use App\Lab4\Factory\Exception\ShapeNotFoundException;
use App\Lab4\Factory\Shapes\Shape;

readonly class PictureDraft
{
    /**
     * @param Shape[] $shapes
     */
    public function __construct(
        private array $shapes,
    )
    {
    }

    public function getShapesCount(): int
    {
        return count($this->shapes);
    }

    /**
     * @return Shape[]
     */
    public function getShapes(): array
    {
        return $this->shapes;
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function getShape(int $index): Shape
    {
        if (!isset($this->shapes[$index]))
        {
            throw new ShapeNotFoundException();
        }
        return $this->shapes[$index];
    }
}
