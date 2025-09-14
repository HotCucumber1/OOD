<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Exception;

class InvalidHexColorException extends \Exception
{
    public function __construct(string $hexColor)
    {
        parent::__construct("$hexColor is invalid hex color");
    }
}
