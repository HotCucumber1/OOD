<?php
declare(strict_types=1);

use App\Lab1\DuckFunctional\Entity\Duck;
use App\Lab1\DuckFunctional\Entity\MallardDuck;
use App\Lab1\DuckFunctional\Entity\RedHeadDuck;

require_once __DIR__ . '/../../../vendor/autoload.php';

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