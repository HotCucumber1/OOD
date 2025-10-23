<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\Exception;

class FailedToSaveFileException extends \Exception
{
    public function __construct(string $fileUrl)
    {
        parent::__construct('Failed to save file: ' . $fileUrl);
    }
}
