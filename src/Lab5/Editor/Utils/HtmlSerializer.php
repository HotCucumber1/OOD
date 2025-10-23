<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Utils;

use App\Lab5\Editor\Document\DocumentInterface;

class HtmlSerializer
{
    public static function serialize(DocumentInterface $document): string
    {
        $title = htmlspecialchars($document->getTitle());
        $bodyContent = '';
        foreach ($document->listItems() as $item)
        {
            $paragraph = $item->getParagraph();
            $image = $item->getImage();

            if (!is_null($paragraph))
            {
                $bodyContent .= '<p>' . htmlspecialchars($paragraph->getText()) . '</p>' . PHP_EOL;
            }
            elseif (!is_null($image))
            {
                $bodyContent .= sprintf(
                    '<img src="%s" width="%d" height="%d" alt="Image">' . PHP_EOL,
                    htmlspecialchars($image->getPath()),
                    $image->getWidth(),
                    $image->getHeight()
                );
            }
        }

        return <<<HTML
            <!DOCTYPE html>
            <html lang="eng">
            <head>
                <meta charset="UTF-8">
                <title>$title</title>
            </head>
            <body>
            $bodyContent
            </body>
            </html>
            HTML;
    }
}