<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Utils;

interface ImageSaveStrategyInterface
{
    public function saveImage(string $sourceUrl): string;
}