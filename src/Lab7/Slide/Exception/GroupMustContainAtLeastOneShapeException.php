<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Exception;

class GroupMustContainAtLeastOneShapeException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Group must contain at least one shape');
    }
}