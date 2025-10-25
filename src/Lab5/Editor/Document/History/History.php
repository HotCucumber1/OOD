<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\History;

use App\Lab5\Editor\Command\CommandInterface;
use App\Lab5\Editor\Command\UndoableCommandInterface;

class History
{
    public const int MAX_DEPTH = 10;
    /**
     * @var UndoableCommandInterface[]
     */
    private array $commands = [];
    private int $nextCommandIndex = 0;

    /**
     * @return UndoableCommandInterface[]
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

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

    public function addAndExecuteCommand(UndoableCommandInterface $command): void
    {
        $command->execute();

        if ($this->nextCommandIndex < count($this->commands))
        {
            $removed = array_splice($this->commands, $this->nextCommandIndex);
            self::cleanUp($removed);
        }

        $wasMerged = $this->tryMerge($command);
        if (!$wasMerged)
        {
            $this->addNewCommand($command);
            $this->nextCommandIndex++;
        }
    }

    private function tryMerge(UndoableCommandInterface $command): bool
    {
        if ($this->nextCommandIndex === 0)
        {
            return false;
        }
        $lastCommand = $this->commands[$this->nextCommandIndex - 1];

        if ($command->replaceEdit($lastCommand))
        {
            $this->commands[$this->nextCommandIndex - 1] = $command;
            return true;
        }
        return false;
    }

    private function addNewCommand(UndoableCommandInterface $command): void
    {
        if (count($this->commands) >= self::MAX_DEPTH)
        {
            $removed = array_shift($this->commands);
            unset($removed);
            $this->nextCommandIndex--;
        }

        $this->commands[] = $command;
    }

    /**
     * @param CommandInterface[] $commands
     */
    private static function cleanUp(array $commands): void
    {
        foreach ($commands as $command)
        {
            unset($command);
        }
    }
}