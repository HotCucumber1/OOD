<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\Exception;

class InvalidItemIndexException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Element index is too large');
    }
}
