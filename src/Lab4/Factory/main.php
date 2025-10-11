<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Lab4\Factory\Canvas\Canvas;
use App\Lab4\Factory\Client\Client;
use App\Lab4\Factory\Client\Designer;
use App\Lab4\Factory\Factory\ShapeFactory;

function main(): void
{
    try
    {
        $canvas = new Canvas();
        $client = new Client($canvas, STDIN);
        $designer = new Designer(new ShapeFactory());

        $client->orderPicture($designer, 'factory_img.png');
    }
    catch (\Exception $e)
    {
        echo $e->getMessage() . PHP_EOL;
        die();
    }
}


main();