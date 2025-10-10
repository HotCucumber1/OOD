<?php

namespace App\Lab4\Factory\Exception;

class ShapeNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Shape not found');
    }
}