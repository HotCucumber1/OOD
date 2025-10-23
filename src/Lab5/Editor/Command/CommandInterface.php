<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

interface CommandInterface
{
    public function execute(): void;

    public function unexecute(): void;
}