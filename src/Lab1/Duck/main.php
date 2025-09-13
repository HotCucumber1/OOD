<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Lab1\Duck\Entity\Duck;
use App\Lab1\Duck\Entity\MallardDuck;
use App\Lab1\Duck\Entity\RedHeadDuck;

function playWithDuck(Duck $duck): void
{
    $duck->display();

    $duck->performQuack();
    $duck->performFly();
    $duck->performDance();

    echo PHP_EOL;
}

function main(): void
{
    $duck = new MallardDuck();
    playWithDuck($duck);

    $duck = new RedHeadDuck();
    playWithDuck($duck);
}


main();