<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

abstract class AbstractCommand implements CommandInterface
{
    private bool $isExecuted = false;

    public function execute(): void
    {
        if (!$this->isExecuted)
        {
            $this->doExecute();
            $this->isExecuted = true;
        }
    }

    public function unexecute(): void
    {
        if ($this->isExecuted)
        {
            $this->doUnexecute();
            $this->isExecuted = false;
        }
    }

    abstract protected function doExecute(): void;

    abstract protected function doUnexecute(): void;
}