<?php
declare(strict_types=1);

namespace Test\Unit\Editor\Mock;

use App\Lab5\Editor\Command\AbstractCommand;

class MockExceptionCommand extends AbstractCommand
{
    public function __construct(
        private int &$counter,
    )
    {
    }

    /**
     * @throws \Exception
     */
    protected function doExecute(): void
    {
        throw new \Exception(':director:');
        $this->counter++;
    }

    protected function doUnexecute(): void
    {
        $this->counter--;
    }
}