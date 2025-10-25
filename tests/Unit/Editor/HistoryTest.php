<?php
declare(strict_types=1);

namespace Test\Unit\Editor;

use App\Lab5\Editor\Document\History\History;
use PHPUnit\Framework\TestCase;
use Test\Unit\Editor\Mock\MockCommand;
use Test\Unit\Editor\Mock\MockExceptionCommand;
use Test\Unit\Editor\Mock\MockMergeCommand;

class HistoryTest extends TestCase
{
    private History $history;

    protected function setUp(): void
    {
        parent::setUp();
        $this->history = new History();
    }

    public function testCanUndoSuccess(): void
    {
        $counter = 0;
        self::assertFalse($this->history->canUndo());
        $this->history->addAndExecuteCommand(
            new MockCommand($counter),
        );

        self::assertTrue($this->history->canUndo());
    }

    public function testUndoSuccess(): void
    {
        $counter = 0;
        $this->history->addAndExecuteCommand(
            new MockCommand($counter),
        );
        self::assertEquals(1, $counter);

        $this->history->undo();
        self::assertEquals(0, $counter);
    }

    public function testCanRedoSuccess(): void
    {
        $counter = 0;
        $this->history->addAndExecuteCommand(
            new MockCommand($counter),
        );

        self::assertFalse($this->history->canRedo());
        $this->history->undo();

        self::assertTrue($this->history->canRedo());
    }

    public function testRedoSuccess(): void
    {
        $counter = 0;
        $this->history->addAndExecuteCommand(
            new MockCommand($counter),
        );
        self::assertEquals(1, $counter);

        $this->history->undo();
        self::assertEquals(0, $counter);

        $this->history->redo();
        self::assertEquals(1, $counter);
    }

    public function testAddAndExecuteCommandSuccess(): void
    {
        $counter = 0;
        $this->history->addAndExecuteCommand(
            new MockCommand($counter),
        );
        self::assertEquals(1, $counter);
    }

    public function testAddAndExecuteCommandFail(): void
    {
        $counter = 0;

        $this->expectException(\Exception::class);
        $this->history->addAndExecuteCommand(
            new MockExceptionCommand($counter),
        );

        self::assertEquals(0, $counter);
    }

    public function testClearCommandsAfterLimitSuccess(): void
    {
        $counter = 0;
        for ($i = 0; $i < History::MAX_DEPTH * 2; $i++)
        {
            $this->history->addAndExecuteCommand(new MockCommand($counter));
        }
        self::assertCount(History::MAX_DEPTH, $this->history->getCommands());
    }

    public function testMergeCommandsSuccess(): void
    {
        $counter = 0;
        $this->history->addAndExecuteCommand(
            new MockCommand($counter),
        );
        $this->history->addAndExecuteCommand(new MockMergeCommand());
        $this->history->addAndExecuteCommand(new MockMergeCommand());
        $this->history->addAndExecuteCommand(new MockMergeCommand());

        self::assertCount(1, $this->history->getCommands());
    }

    public function testDeleteCommandsAfterUndoAndNewCommandsSuccess(): void
    {
        $counter = 0;
        $this->history->addAndExecuteCommand(new MockCommand($counter));
        $this->history->addAndExecuteCommand(new MockCommand($counter));

        $this->history->undo();
        $this->history->addAndExecuteCommand(new MockCommand($counter));

        self::assertCount(2, $this->history->getCommands());
    }
}