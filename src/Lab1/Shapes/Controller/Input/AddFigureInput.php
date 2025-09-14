<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Controller\Input;

class AddFigureInput
{
    /**
     * @param string[] $params
     */
    public function __construct(
        public readonly string $shapeId,
        public readonly string $color,
        public readonly string $shapeType,
        public readonly array  $params,
    )
    {
    }
}