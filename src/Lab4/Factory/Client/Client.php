<?php
declare(strict_types=1);

namespace App\Lab4\Factory\Client;

use App\Lab4\Factory\Canvas\CanvasInterface;
use App\Lab4\Factory\Exception\StreamIsNotResourceException;

class Client
{
    /**
     * @param resource $stream
     * @throws StreamIsNotResourceException
     */
    public function __construct(
        private readonly CanvasInterface $canvas,
        private                          $stream = STDIN,
    )
    {
        if (!is_resource($this->stream))
        {
            throw new StreamIsNotResourceException();
        }
    }

    public function orderPicture(DesignerInterface $designer, string $filename): void
    {
        $draft = $designer->createDraft($this->stream);
        Painter::draw($draft, $this->canvas);

        $this->canvas->saveToFile($filename);
    }
}