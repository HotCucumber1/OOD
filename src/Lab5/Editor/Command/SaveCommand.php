<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Command;

use App\Lab5\Editor\Command\Exception\FileNotFound;
use App\Lab5\Editor\Document\DocumentInterface;
use App\Lab5\Editor\Document\Exception\FailedToSaveFileException;
use App\Lab5\Editor\Utils\HtmlSerializer;

final class SaveCommand extends AbstractCommand
{
    public function __construct(
        private readonly DocumentInterface $document,
        private readonly string            $fileUrl,
    )
    {
    }

    /**
     * @throws FailedToSaveFileException
     */
    protected function doExecute(): void
    {
        $documentContent = HtmlSerializer::serialize($this->document);
        if (!file_put_contents($this->fileUrl, $documentContent))
        {
            throw new FailedToSaveFileException($this->fileUrl);
        }
    }

    /**
     * @throws FileNotFound
     */
    protected function doUnexecute(): void
    {
        if (!file_exists($this->fileUrl))
        {
            throw new FileNotFound($this->fileUrl);
        }
        if (!unlink($this->fileUrl))
        {
            throw new \RuntimeException('Failed to delete file.');
        }
    }
}
