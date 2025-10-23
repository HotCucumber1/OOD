<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Controller\Exception;

class UnknownCommandException extends \Exception
{
    public function __construct(string $command)
    {
        parent::__construct('Unknown command: "' . $command);
    }
}