<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Common;

interface CopyableInterface
{
    public function clone(): CopyableInterface;
}