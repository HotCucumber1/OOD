<?php

namespace App\Lab4\Factory\Exception;

class StreamIsNotResourceException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Stream is not a resource stream');
    }
}