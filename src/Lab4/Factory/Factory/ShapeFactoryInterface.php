<?php

namespace App\Lab4\Factory\Factory;

use App\Lab4\Factory\Shapes\Shape;

interface ShapeFactoryInterface
{
    public function createShape(string $description): Shape;
}