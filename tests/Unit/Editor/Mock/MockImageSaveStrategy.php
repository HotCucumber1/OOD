<?php
declare(strict_types=1);

namespace Test\Unit\Editor\Mock;

use App\Lab5\Editor\Utils\ImageSaveStrategyInterface;

class MockImageSaveStrategy implements ImageSaveStrategyInterface
{
    public function saveImage(string $sourceUrl): string
    {
        return $sourceUrl;
    }
}