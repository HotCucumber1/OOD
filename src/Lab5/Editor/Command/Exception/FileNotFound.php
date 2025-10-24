<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command\Exception;

class FileNotFound extends \Exception
{
    public function __construct(string $fileUrl)
    {
        parent::__construct("File '{$fileUrl}' not found.");
    }
}