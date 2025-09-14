<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Exception;

class ShapeNotFoundException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct("Shape with id <$id> not found");
    }
}