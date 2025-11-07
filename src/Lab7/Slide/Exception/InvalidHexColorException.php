<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Exception;

class InvalidHexColorException extends \Exception
{
    public function __construct(string $hex)
    {
        parent::__construct('Invalid hex color: ' . $hex);
    }
}