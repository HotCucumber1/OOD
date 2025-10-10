<?php
declare(strict_types=1);

namespace App\Lab4\Factory\Exception;

class ShapeNotSpecifiedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Shape not specified');
    }
}