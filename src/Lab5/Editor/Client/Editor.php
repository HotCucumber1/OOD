<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Client;

use App\Lab5\Editor\Controller\EditorController;
use App\Lab5\Editor\Controller\Exception\UnknownCommandException;
use App\Lab5\Editor\Document\Document;
use App\Lab5\Editor\Utils\ImageSaveStrategy;

class Editor
{
    private EditorController $controller;

    public function __construct()
    {
        $this->controller = new EditorController(
            new Document(
                new ImageSaveStrategy(),
            ),
        );
    }

    /**
     * @throws UnknownCommandException
     */
    public function run(): void
    {
        $this->controller->processCommands();
    }
}