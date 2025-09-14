<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Exception;

class ShapeAlreadyExistsException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct("Shape with id <$id> already exists");
    }
}