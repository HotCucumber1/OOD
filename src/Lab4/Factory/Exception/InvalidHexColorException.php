<?php
declare(strict_types=1);

namespace App\Lab4\Factory\Exception;

class InvalidHexColorException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid hex color');
    }
}