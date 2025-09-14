<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Exception;

class UndefinedFigureException extends \Exception
{
    public function __construct(string $figure)
    {
        parent::__construct("Undefined figure <$figure>");
    }
}