<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Utils;

use Ramsey\Uuid\Uuid;

class ImageSaveStrategy implements ImageSaveStrategyInterface
{
    private const string DST_DIR = 'images/';

    public function saveImage(string $sourceUrl): string
    {
        $extension = pathinfo($sourceUrl, PATHINFO_EXTENSION);
        $newName = Uuid::uuid4()->toString() . '.' . $extension;

        if (!is_dir(self::DST_DIR) &&
            !mkdir($concurrentDirectory = self::DST_DIR) && !is_dir($concurrentDirectory))
        {
            throw new \RuntimeException("Directory {$concurrentDirectory} was not created");
        }

        $fileUrl = self::DST_DIR . $newName;
        if (!copy($sourceUrl, $fileUrl))
        {
            throw new \RuntimeException("Failed to copy file {$sourceUrl} to {$fileUrl}");
        }
        return $fileUrl;
    }
}
