<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Controller;

use App\Lab5\Editor\Controller\Exception\UnknownCommandException;
use App\Lab5\Editor\Document\Data\ImageInterface;
use App\Lab5\Editor\Document\Data\ParagraphInterface;
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

    private const array COMMANDS_INFO = [
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
    ];

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
            $this->executeCommand($line);
            // var_dump($this->document->listItems());

            if (isset($line[0]) && $line[0] === self::SAVE)
            {
                break;
            }
        }
    }

    /**
     * @throws UnknownCommandException
     */
    private function executeCommand(string $line): void
    {
        $args = explode(' ', $line);

        // TODO везде валидация
        try
        {
            match ($args[0])
            {
                self::INSERT_PARAGRAPH => $this->insertParagraph($args),
                self::INSERT_IMAGE => $this->insertImage($args),
                self::SET_TITLE => $this->setTitle($args),
                self::LIST => $this->listItems(),
                self::REPLACE_TEXT => $this->replaceText($args),
                self::RESIZE_IMAGE => $this->resizeImage($args),
                self::DELETE_ITEM => $this->deleteItem($args),
                self::HELP => self::help(),
                self::UNDO => $this->document->undo(),
                self::REDO => $this->document->redo(),
                self::SAVE => $this->saveDocument($args),
                default => throw new UnknownCommandException($args[0]),
            };
        }
        catch (\Throwable $e)
        {
            echo $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * @param string[] $args
     */
    private function insertParagraph(array $args): void
    {
        $text = $args[2];
        $position = $args[1] === 'end'
            ? null
            : (int) $args[1];

        $this->document->insertParagraph($text, $position);
    }

    /**
     * @param string[] $args
     */
    private function insertImage(array $args): void
    {
        $width = (int) $args[2];
        $height = (int) $args[3];
        $fileUrl = $args[4];
        $position = $args[1] === 'end' ? null : (int) $args[1];

        $this->document->insertImage($fileUrl, $width, $height, $position);
    }

    /**
     * @param string[] $args
     */
    private function setTitle(array $args): void
    {
        $this->document->setTitle($args[1]);
    }

    private function listItems(): void
    {
        $title = $this->document->getTitle();
        $items = $this->document->listItems();

        echo 'Title: ' . $title;
        foreach ($items as $index => $item)
        {
            $message = $index . '. ';
            if ($item instanceof ImageInterface)
            {
                $message .= 'Image: ' . self::getImageInfo($item);
            }
            elseif ($item instanceof ParagraphInterface)
            {
                $message .= 'Paragraph: ' . $item->getText();
            }
            echo $message;
        }
    }

    /**
     * @param string[] $args
     */
    private function replaceText(array $args): void
    {
        $position = (int) $args[1];
        $text = $args[2];

        $this->document->replaceParagraphText($position, $text);
    }

    /**
     * @param string[] $args
     */
    private function resizeImage(array $args): void
    {
        $position = (int) $args[1];
        $width = (int) $args[2];
        $height = (int) $args[3];

        $this->document->resizeImage($position, $width, $height);
    }

    /**
     * @param string[] $args
     */
    private function deleteItem(array $args): void
    {
        $position = (int) $args[1];
        $this->document->deleteItem($position);
    }

    private static function help(): void
    {
        foreach (self::COMMANDS_INFO as $command => $description)
        {
            echo $command . ': ' . $description . PHP_EOL;
        }
    }

    /**
     * @param string[] $args
     */
    private function saveDocument(array $args): void
    {
        $fileUrl = $args[1];
        $this->document->save($fileUrl);
    }

    private static function getImageInfo(ImageInterface $image): string
    {
        return $image->getWidth() . 'x' . $image->getHeight() . ' ' . $image->getPath();
    }
}
