<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Controller;

use App\Lab5\Editor\Command\CommandInterface;
use App\Lab5\Editor\Command\DeleteItemCommand;
use App\Lab5\Editor\Command\HelpCommand;
use App\Lab5\Editor\Command\InsertImageCommand;
use App\Lab5\Editor\Command\InsertParagraphCommand;
use App\Lab5\Editor\Command\ListCommand;
use App\Lab5\Editor\Command\ReplaceTextCommand;
use App\Lab5\Editor\Command\ResizeImageCommand;
use App\Lab5\Editor\Command\SaveCommand;
use App\Lab5\Editor\Command\SetTitleCommand;
use App\Lab5\Editor\Controller\Exception\UnknownCommandException;
use App\Lab5\Editor\Document\DocumentInterface;

readonly class EditorController
{
    private const string INSERT_PARAGRAPH = 'InsertParagraph';
    private const string INSERT_IMAGE = 'InsertImage';
    private const string SET_TITLE = 'SetTitle';
    private const string LIST = 'List';
    private const string REPLACE_TEXT = 'ReplaceText';
    private const string RESIZE_IMAGE = 'ResizeImage';
    private const string DELETE_ITEM = 'DeleteItem';
    private const string HELP = 'Help';
    private const string UNDO = 'Undo';
    private const string REDO = 'Redo';
    private const string SAVE = 'Save';

    public function __construct(
        private DocumentInterface $document,
    )
    {
    }

    /**
     * @throws UnknownCommandException
     */
    public function processCommands(): void
    {
        while (!feof(STDIN))
        {
            $line = trim(fgets(STDIN));
            if (!$line)
            {
                break;
            }
            $command = $this->getCommand($line);
            $command->execute();

            if ($command instanceof SaveCommand)
            {
                break;
            }
        }
    }

    /**
     * @throws UnknownCommandException
     */
    private function getCommand(string $line): CommandInterface
    {
        $args = explode(' ', $line);
        // TODO везде валидация

        return match ($args[0])
        {
            self::INSERT_PARAGRAPH => $this->getInsertParagraphCommand($args),
            self::INSERT_IMAGE => $this->getInsertImageCommand($args),
            self::SET_TITLE => $this->getSetTitleCommand($args),
            self::LIST => $this->getListCommand(),
            self::REPLACE_TEXT => $this->getReplaceTextCommand($args),
            self::RESIZE_IMAGE => $this->getResizeImageCommand($args),
            self::DELETE_ITEM => $this->getDeleteItemCommand($args),
            self::HELP => self::getHelpCommand(),
            self::UNDO => self::getHelpCommand(), // TODO заменить
            self::REDO => self::getHelpCommand(),
            self::SAVE => $this->getSaveCommand($args),
            default => throw new UnknownCommandException($args[0]),
        };
    }

    /**
     * @param string[] $args
     */
    private function getInsertParagraphCommand(array $args): InsertParagraphCommand
    {
        $text = $args[2];
        $position = $args[1] === 'end' ? null : (int) $args[1];
        return new InsertParagraphCommand($this->document, $text, $position);
    }

    /**
     * @param string[] $args
     */
    private function getInsertImageCommand(array $args): InsertImageCommand
    {
        $width = (int) $args[2];
        $height = (int) $args[3];
        $fileUrl = $args[4];
        $position = $args[1] === 'end' ? null : (int) $args[1];

        return new InsertImageCommand($this->document, $fileUrl, $width, $height, $position);
    }

    /**
     * @param string[] $args
     */
    private function getSetTitleCommand(array $args): SetTitleCommand
    {
        $title = $args[1];
        return new SetTitleCommand($this->document, $title);
    }

    private function getListCommand(): ListCommand
    {
        return new ListCommand($this->document, STDOUT);
    }

    /**
     * @param string[] $args
     */
    private function getReplaceTextCommand(array $args): ReplaceTextCommand
    {
        $position = (int) $args[1];
        $text = $args[2];

        return new ReplaceTextCommand($this->document, $position, $text);
    }

    /**
     * @param string[] $args
     */
    private function getResizeImageCommand(array $args): ResizeImageCommand
    {
        $position = (int) $args[1];
        $width = (int) $args[2];
        $height = (int) $args[3];

        return new ResizeImageCommand($this->document, $position, $width, $height);
    }

    /**
     * @param string[] $args
     */
    private function getDeleteItemCommand(array $args): DeleteItemCommand
    {
        $position = (int) $args[1];
        return new DeleteItemCommand($this->document, $position);
    }

    private static function getHelpCommand(): HelpCommand
    {
        return new HelpCommand([
            self::INSERT_PARAGRAPH => '',
            self::INSERT_IMAGE => '',
            self::SET_TITLE => '',
            self::LIST => '',
            self::REPLACE_TEXT => '',
            self::RESIZE_IMAGE => '',
            self::DELETE_ITEM => '',
            self::HELP => '',
            self::UNDO => '',
            self::REDO => '',
            self::SAVE => '',
        ]);
    }

    /**
     * @param string[] $args
     */
    private function getSaveCommand(array $args): SaveCommand
    {
        $fileUrl = $args[1];
        return new SaveCommand($this->document, $fileUrl);
    }
}
