<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Client;

use App\Lab5\Editor\Controller\EditorController;
use App\Lab5\Editor\Controller\Exception\UnknownCommandException;
use App\Lab5\Editor\Document\Document;

class Editor
{
    private EditorController $controller;

    public function __construct()
    {
        $this->controller = new EditorController(new Document());
    }

    /**
     * @throws UnknownCommandException
     */
    public function run(): void
    {
        $this->controller->processCommands();
    }
}