<?php
declare(strict_types=1);

namespace App\Lab4\Factory\Factory;

use App\Lab4\Factory\Shapes\Shape;

interface ShapeFactoryInterface
{
    public function createShape(string $description): Shape;
}