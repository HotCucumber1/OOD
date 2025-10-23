<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

class HelpCommand implements CommandInterface
{
    /**
     * @param array<string, string> $commandsInfo
     * @param resource $stream
     */
    public function __construct(
        private readonly array $commandsInfo,
        private                $stream = STDOUT,
    )
    {
    }

    public function execute(): void
    {
        foreach ($this->commandsInfo as $command => $description)
        {
            fwrite($this->stream, $command . ': ' . $description . PHP_EOL);
        }
    }

    public function unexecute(): void
    {
    }
}