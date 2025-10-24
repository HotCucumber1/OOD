<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\History;

use App\Lab5\Editor\Command\CommandInterface;

class History
{
    private const int MAX_DEPTH = 10;
    /**
     * @var CommandInterface[]
     */
    private array $commands = [];
    private int $nextCommandIndex = 0;

    public function canUndo(): bool
    {
        return $this->nextCommandIndex !== 0;
    }

    public function undo(): void
    {
        if ($this->canUndo())
        {
            $this->commands[--$this->nextCommandIndex]->unexecute();
        }
    }

    public function canRedo(): bool
    {
        return $this->nextCommandIndex !== count($this->commands);
    }

    public function redo(): void
    {
        if ($this->canRedo())
        {
            $this->commands[$this->nextCommandIndex]->execute();
            $this->nextCommandIndex++;
        }
    }

    public function addAndExecuteCommand(CommandInterface $command): void
    {
        $command->execute();

        if ($this->nextCommandIndex < count($this->commands))
        {
            $this->nextCommandIndex++;
            $removed = array_splice($this->commands, $this->nextCommandIndex);
            $this->commands[count($this->commands) - 1] = $command;

            self::clenUp($removed);
            return;
        }

        if ($this->nextCommandIndex < self::MAX_DEPTH)
        {
            $this->nextCommandIndex++;
        }
        else
        {
            $removed = array_shift($this->commands);
            unset($removed);
        }
        $this->commands[] = $command;
    }

    /**
     * @param CommandInterface[] $commands
     */
    private static function clenUp(array $commands): void
    {
        foreach ($commands as $command)
        {
            unset($command);
        }
    }
}