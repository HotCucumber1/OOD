<?php
declare(strict_types=1);

use App\Lab5\Editor\Client\Editor;

require_once __DIR__ . '/../../../vendor/autoload.php';

function main(): void
{
    try
    {
        $editor = new Editor();
        $editor->run();
    }
    catch (\Exception $exception)
    {
        echo $exception->getMessage() . PHP_EOL;
    }
}

main();

// /home/dmitriy.rybakov/Downloads/photo_2025-10-24_14-40-32.jpg
