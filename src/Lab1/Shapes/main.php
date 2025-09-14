<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Lab1\Shapes\Controller\ShapeController;

function main(): void
{
    try
    {
        $shapesApp = new ShapeController('lab_image.png');
        $shapesApp->run();
    }
    catch (\Exception $exception)
    {
        echo $exception->getMessage() . PHP_EOL;
        die();
    }
}

main();
