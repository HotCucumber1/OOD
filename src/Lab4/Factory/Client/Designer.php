<?php

namespace App\Lab4\Factory\Client;

use App\Lab4\Factory\Factory\ShapeFactoryInterface;

readonly class Designer implements DesignerInterface
{
    public function __construct(
        private ShapeFactoryInterface $shapeFactory,
    )
    {
    }

    /**
     * @param resource $stream
     */
    public function createDraft($stream): PictureDraft
    {
        $shapes = [];
        while (!feof($stream))
        {
            $line = fgets($stream);
            if (!$line)
            {
                break;
            }
            $shapes[] = $this->shapeFactory->createShape($line);
        }

        return new PictureDraft($shapes);
    }
}