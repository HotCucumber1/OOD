<?php
declare(strict_types=1);

use App\Lab7\Slide\Canvas\Canvas;
use App\Lab7\Slide\Common\FillStyle;
use App\Lab7\Slide\Common\Frame;
use App\Lab7\Slide\Common\Point;
use App\Lab7\Slide\Common\StrokeStyle;
use App\Lab7\Slide\Drawable\Ellipse;
use App\Lab7\Slide\Drawable\ShapeGroup;
use App\Lab7\Slide\Drawable\Slide;
use App\Lab7\Slide\Drawable\Rectangle;
use App\Lab7\Slide\Drawable\SlideComponentInterface;
use App\Lab7\Slide\Drawable\Triangle;

require_once __DIR__ . '/../../../vendor/autoload.php';

main();

function main(): void
{
    try
    {
        $canvas = new Canvas(500, 400);
        $slide = new Slide();

        $slide->addComponent(
            new Rectangle(
                0, 0, 500, 400,
                new FillStyle('#00BFFF', true),
                new StrokeStyle('#000000', 1, false),
            ),
        );

        $shapes = getBeaver();

        $group = new ShapeGroup($shapes);

        $group->setFrame(new Frame(-100, 200, 500, 300));

        $slide->addComponent($group);

        $slide->draw($canvas);
        $canvas->saveToFile('./house.png');
    }
    catch (Exception $e)
    {
        echo $e->getMessage() . PHP_EOL;
        return;
    }
}

/**
 * @return SlideComponentInterface[]
 */
function getCarShapes(): array
{
    return [
        // Основной кузов
        new Rectangle(
            80, 160, 370, 200,  // длинный кузов
            new FillStyle('#FFD700', true),
            new StrokeStyle('#000000', 2, true),
        ),

        // Кабина (треугольная крыша для УАЗика)
        new Triangle(
            250, 160, 370, 160, 250, 120,  // x1,y1, x2,y2, x3,y3
            new FillStyle('#FFD700', true),
            new StrokeStyle('#000000', 2, true),
        ),

        // Лобовое стекло (треугольное)
        new Triangle(
            260, 150, 360, 150, 260, 130,  // x1,y1, x2,y2, x3,y3
            new FillStyle('#87CEEB', true),
            new StrokeStyle('#000000', 1, true),
        ),

        // Боковое окно
        new Rectangle(
            150, 165, 240, 180,  // x1, y1, x2, y2
            new FillStyle('#87CEEB', true),
            new StrokeStyle('#000000', 1, true),
        ),

        // Переднее колесо
        new Ellipse(
            new Point(130, 200), 25, 20,
            new FillStyle('#2F4F4F', true),
            new StrokeStyle('#000000', 2, true),
        ),

        // Заднее колесо
        new Ellipse(
            new Point(320, 200), 25, 20,
            new FillStyle('#2F4F4F', true),
            new StrokeStyle('#000000', 2, true),
        ),

        // Фары
        new Ellipse(
            new Point(60, 170), 12, 8,
            new FillStyle('#FFFFFF', true),
            new StrokeStyle('#000000', 1, true),
        ),

        // Решетка радиатора
        new Rectangle(
            70, 165, 90, 185,  // x1, y1, x2, y2
            new FillStyle('#696969', true),
            new StrokeStyle('#000000', 1, true),
        )
    ];
}

/**
 * @return SlideComponentInterface[]
 */
function getBeaver(): array
{
    return [
        new Ellipse(
            new Point(250, 250), 80, 150,
            new FillStyle('#8B4513', true),
            new StrokeStyle('#000000', 2, true),
        ),

        new Ellipse(
            new Point(250, 150), 50, 60,
            new FillStyle('#8B4513', true),
            new StrokeStyle('#000000', 2, true),
        ),

        new Ellipse(
            new Point(250, 130), 30, 20,
            new FillStyle('#000000', true),
            new StrokeStyle('#000000', 1, true),
        ),

        new Ellipse(
            new Point(230, 140), 8, 8,
            new FillStyle('#000000', true),
            new StrokeStyle('#000000', 1, true),
        ),

        new Ellipse(
            new Point(270, 140), 8, 8,
            new FillStyle('#000000', true),
            new StrokeStyle('#000000', 1, true),
        ),

        new Rectangle(
            240, 115, 260, 125,
            new FillStyle('#FFFFFF', true),
            new StrokeStyle('#000000', 1, true),
        ),

        new Ellipse(
            new Point(220, 160), 20, 20,
            new FillStyle('#8B4513', true),
            new StrokeStyle('#000000', 1, true),
        ),

        new Ellipse(
            new Point(280, 160), 20, 20,
            new FillStyle('#8B4513', true),
            new StrokeStyle('#000000', 1, true),
        ),

        new Ellipse(
            new Point(250, 350), 30, 60,
            new FillStyle('#654321', true),
            new StrokeStyle('#000000', 2, true),
        ),

        new Ellipse(
            new Point(210, 200), 20, 30,
            new FillStyle('#8B4513', true),
            new StrokeStyle('#000000', 1, true),
        ),

        new Ellipse(
            new Point(290, 200), 20, 30,
            new FillStyle('#8B4513', true),
            new StrokeStyle('#000000', 1, true),
        ),

        new Ellipse(
            new Point(210, 300), 20, 30,
            new FillStyle('#8B4513', true),
            new StrokeStyle('#000000', 1, true),
        ),

        new Ellipse(
            new Point(290, 300), 20, 30,
            new FillStyle('#8B4513', true),
            new StrokeStyle('#000000', 1, true),
        )
    ];
}
