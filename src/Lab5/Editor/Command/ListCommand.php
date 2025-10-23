<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Document\Data\ImageInterface;
use App\Lab5\Editor\Document\Data\ParagraphInterface;
use App\Lab5\Editor\Document\DocumentInterface;

class ListCommand implements CommandInterface
{
    /**
     * @param resource $stream
     */
    public function __construct(
        private readonly DocumentInterface $document,
        private                            $stream = STDOUT,
    )
    {
    }

    public function execute(): void
    {
        $title = $this->document->getTitle();
        $items = $this->document->listItems();

        $this->print('Title: ' . $title);
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
            $this->print($message);
        }
    }

    public function unexecute(): void
    {
        // TODO: Implement unexecute() method.
    }

    private function print(string $message): void
    {
        fwrite($this->stream, $message . PHP_EOL);
    }

    private static function getImageInfo(ImageInterface $image): string
    {
        return $image->getWidth() . 'x' . $image->getHeight() . ' ' . $image->getPath();
    }
}
