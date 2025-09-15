<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Entity;

use App\Lab1\Shapes\Exception\ShapeAlreadyExistsException;
use App\Lab1\Shapes\Exception\ShapeNotFoundException;

class Picture
{
    /**
     * @var array<string, Shape>
     */
    private array $shapes = [];

    public function __construct(
        private readonly CanvasInterface $canvas,
    )
    {
    }

    public function draw(): void
    {
        foreach ($this->shapes as $shape)
        {
            $shape->draw($this->canvas);
        }
    }

    public function downloadPicture(): void
    {
        $this->canvas->draw();
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function drawShape(string $id): void
    {
        if (!isset($this->shapes[$id]))
        {
            throw new ShapeNotFoundException($id);
        }
        $this->shapes[$id]->draw($this->canvas);
    }

    public function move(float $dx, float $dy): void
    {
        foreach ($this->shapes as $shape)
        {
            $shape->move($dx, $dy);
        }
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    public function storeShape(string $id, Shape $shape): void
    {
        if (isset($this->shapes[$id]))
        {
            throw new ShapeAlreadyExistsException($id);
        }
        $this->shapes[$id] = $shape;
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function deleteShape(string $id): void
    {
        if (!isset($this->shapes[$id]))
        {
            throw new ShapeNotFoundException($id);
        }
        unset($this->shapes[$id]);
    }

    /**
     * @return array<string, Shape>
     */
    public function listShapes(): array
    {
        return $this->shapes;
    }

    /**
     * @throws ShapeNotFoundException
     */
    public function findShape(string $id): Shape
    {
        if (!isset($this->shapes[$id]))
        {
            throw new ShapeNotFoundException($id);
        }
        return $this->shapes[$id];
    }

    /**
     * @throws ShapeNotFoundException
     * @throws ShapeAlreadyExistsException
     */
    public function cloneShape(
        string $sourceShapeId,
        string $newShapeId,
    ): void
    {
        $shape = $this->findShape($sourceShapeId);
        $newShape = $shape->clone();

        $this->storeShape($newShapeId, $newShape);
    }
}