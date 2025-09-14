<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Controller;

use App\Lab1\Shapes\Controller\Input\AddFigureInput;
use App\Lab1\Shapes\Entity\Picture;
use App\Lab1\Shapes\Entity\Shape;
use App\Lab1\Shapes\Exception\ShapeAlreadyExistsException;
use App\Lab1\Shapes\Exception\ShapeNotFoundException;
use App\Lab1\Shapes\Exception\UndefinedFigureException;
use App\Lab1\Shapes\Infrastructure\Canvas;
use App\Lab1\Shapes\Strategy\EllipseStrategy;
use App\Lab1\Shapes\Strategy\LineStrategy;
use App\Lab1\Shapes\Strategy\RectangleStrategy;
use App\Lab1\Shapes\Strategy\TextStrategy;
use App\Lab1\Shapes\Strategy\TriangleStrategy;

class ShapeController
{
    private const ADD_COMMAND_ARG_COUNT = 5;
    private const MOVE_SHAPE_COMMAND_ARG_COUNT = 3;
    private const MOVE_PICT_COMMAND_ARG_COUNT = 2;
    private const DELETE_COMMAND_ARG_COUNT = 1;
    private const CHANGE_COLOR_COMMAND_ARG_COUNT = 2;
    private const DRAW_SHAPE_COMMAND_ARG_COUNT = 1;

    private const RECT_PARAMS_COUNT = 4;
    private const CIRCLE_PARAMS_COUNT = 3;
    private const TRIANGLE_PARAMS_COUNT = 4;

    private Picture $picture;

    public function __construct(string $fileUrl)
    {
        $this->picture = new Picture(
            new Canvas($fileUrl),
        );
    }

    /**
     * @throws ShapeAlreadyExistsException
     * @throws ShapeNotFoundException
     * @throws UndefinedFigureException
     */
    public function run(): void
    {
        while (!feof(STDIN))
        {
            $line = fgets(STDIN);
            if (!$line)
            {
                break;
            }
            $this->processCommand(trim($line));
        }
        $this->picture->downloadPicture();
    }

    /**
     * @throws ShapeAlreadyExistsException
     * @throws ShapeNotFoundException
     * @throws UndefinedFigureException
     */
    private function processCommand(string $line): void
    {
        $arguments = explode(' ', $line);
        if (empty($arguments))
        {
            throw new \InvalidArgumentException('Wrong argument number');
        }

        $command = $arguments[0];
        $params = array_slice($arguments, 1);

        match ($command)
        {
            'AddShape' => $this->addShape($params),
            'MoveShape' => $this->moveShape($params),
            'MovePicture' => $this->movePicture($params),
            'DeleteShape' => $this->deleteShape($params),
            'List' => $this->listShapes(),
            'ChangeColor' => $this->changeColor($params),
            'ChangeShape' => $this->changeShape($params),
            'DrawShape' => $this->drawShape($params),
            'DrawPicture' => $this->drawPicture(),
        };
    }

    /**
     * @throws ShapeAlreadyExistsException
     * @throws UndefinedFigureException
     */
    private function addShape(array $arguments): void
    {
        self::assertArgumentsCount($arguments, self::ADD_COMMAND_ARG_COUNT);

        $input = new AddFigureInput(
            $arguments[0],
            $arguments[1],
            $arguments[2],
            array_slice($arguments, 3),
        );

        match ($input->shapeType)
        {
            'circle' => $this->addCircle($input),
            'rectangle' => $this->addRectangle($input),
            'triangle' => $this->addTriangle($input),
            'line' => $this->addLine($input),
            'text' => $this->addText($input),
            default => throw new UndefinedFigureException($input->shapeType),
        };
    }

    /**
     * @param string[] $arguments
     * @throws ShapeNotFoundException
     */
    private function moveShape(array $arguments): void
    {
        self::assertArgumentsCount($arguments, self::MOVE_SHAPE_COMMAND_ARG_COUNT);

        $shapeId = $arguments[0];
        $dx = (float)$arguments[1];
        $dy = (float)$arguments[2];

        $this->picture
            ->findShape($shapeId)
            ->move($dx, $dy);
    }

    private function movePicture(array $arguments): void
    {
        self::assertArgumentsCount($arguments, self::MOVE_PICT_COMMAND_ARG_COUNT);

        $dx = (float)$arguments[0];
        $dy = (float)$arguments[1];

        $this->picture->move($dx, $dy);
    }

    /**
     * @throws ShapeNotFoundException
     */
    private function deleteShape(array $arguments): void
    {
        self::assertArgumentsCount($arguments, self::DELETE_COMMAND_ARG_COUNT);
        $this->picture->deleteShape($arguments[0]);
    }

    private function listShapes(): void
    {
        $shapes = $this->picture->listShapes();
        foreach ($shapes as $id => $shape)
        {
            self::printShapeInfo($id, $shape);
        }
    }

    /**
     * @param string[] $arguments
     * @throws ShapeNotFoundException
     */
    private function changeColor(array $arguments): void
    {
        self::assertArgumentsCount($arguments, self::CHANGE_COLOR_COMMAND_ARG_COUNT);

        $shapeId = $arguments[0];
        $color = $arguments[1];

        $this->picture
            ->findShape($shapeId)
            ->setColor($color);
    }

    /**
     * @throws ShapeNotFoundException
     */
    private function changeShape(array $arguments): void
    {
        self::assertArgumentsCount($arguments, self::ADD_COMMAND_ARG_COUNT);

        $input = new AddFigureInput(
            $arguments[0],
            $arguments[1],
            $arguments[2],
            array_slice($arguments, 3),
        );

        $strategy = match ($input->shapeType)
        {
            'circle' => self::getEllipseStrategy($input->params),
            'rectangle' => self::getRectangleStrategy($input->params),
            'triangle' => self::getTriangleStrategy($input->params),
            'line' => self::getLineStrategy($input->params),
            'text' => self::getTextStrategy($input->params),
        };

        $this->picture
            ->findShape($input->shapeId)
            ->setStrategy($strategy);
    }

    /**
     * @throws ShapeNotFoundException
     */
    private function drawShape(array $arguments): void
    {
        self::assertArgumentsCount($arguments, self::DRAW_SHAPE_COMMAND_ARG_COUNT);

        $this->picture->drawShape($arguments[0]);
    }

    private function drawPicture(): void
    {
        $this->picture->draw();
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    private function addCircle(AddFigureInput $input): void
    {
        self::assertShapeParams(
            $input->params,
            self::CIRCLE_PARAMS_COUNT,
        );

        $circle = new Shape(
            self::getEllipseStrategy($input->params),
            $input->color,
        );
        $this->picture->storeShape(
            $input->shapeId,
            $circle,
        );
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    private function addRectangle(AddFigureInput $input): void
    {
        self::assertShapeParams(
            $input->params,
            self::RECT_PARAMS_COUNT,
        );

        $rect = new Shape(
            self::getRectangleStrategy($input->params),
            $input->color,
        );
        $this->picture->storeShape(
            $input->shapeId,
            $rect,
        );
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    private function addTriangle(AddFigureInput $input): void
    {
        self::assertShapeParams(
            $input->params,
            self::TRIANGLE_PARAMS_COUNT,
        );

        $rect = new Shape(
            self::getTriangleStrategy($input->params),
            $input->color,
        );
        $this->picture->storeShape(
            $input->shapeId,
            $rect,
        );
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    private function addLine(AddFigureInput $input): void
    {
        $rect = new Shape(
            self::getLineStrategy($input->params),
            $input->color,
        );
        $this->picture->storeShape(
            $input->shapeId,
            $rect,
        );
    }

    /**
     * @throws ShapeAlreadyExistsException
     */
    private function addText(AddFigureInput $input): void
    {
        $rect = new Shape(
            self::getTextStrategy($input->params),
            $input->color,
        );
        $this->picture->storeShape(
            $input->shapeId,
            $rect,
        );
    }

    private static function printShapeInfo(string $id, Shape $shape): void
    {
        echo $id . ' ' . $shape->getInfo() . PHP_EOL;
    }

    /**
     * @param string[] $params
     */
    private static function assertShapeParams(array $params, int $paramsCount): void
    {
        self::assertArgumentsCount($params, $paramsCount);
        self::assertShapeCoords($params);
    }

    private static function assertArgumentsCount(array $arguments, int $argumentsCount): void
    {
        if (count($arguments) < $argumentsCount)
        {
            throw new \InvalidArgumentException('Wrong argument number');
        }
    }

    /**
     * @param string[] $params
     */
    private static function assertShapeCoords(array $params): void
    {
        foreach ($params as $param)
        {
            if ($param !== '0' && floatval($param) === 0.0)
            {
                throw new \InvalidArgumentException('Argument must be float');
            }
        }
    }

    /**
     * @param string[] $params
     */
    private static function getEllipseStrategy(array $params): EllipseStrategy
    {
        return new EllipseStrategy(
            (float)$params[0],
            (float)$params[1],
            (float)$params[2],
            (float)$params[2],
        );
    }

    /**
     * @param string[] $params
     */
    private static function getRectangleStrategy(array $params): RectangleStrategy
    {
        return new RectangleStrategy(
            (float)$params[0],
            (float)$params[1],
            (float)$params[2],
            (float)$params[3],
        );
    }

    /**
     * @param string[] $params
     */
    private static function getTriangleStrategy(array $params): TriangleStrategy
    {
        return new TriangleStrategy(
            (float)$params[0],
            (float)$params[1],
            (float)$params[2],
            (float)$params[3],
            (float)$params[4],
            (float)$params[5],
        );
    }

    /**
     * @param string[] $params
     */
    private static function getLineStrategy(array $params): LineStrategy
    {
        return new LineStrategy(
            (float)$params[0],
            (float)$params[1],
            (float)$params[2],
            (float)$params[3],
        );
    }

    /**
     * @param string[] $params
     */
    private static function getTextStrategy(array $params): TextStrategy
    {
        return new TextStrategy(
            (float)$params[0],
            (float)$params[1],
            (int)$params[2],
            $params[3],
        );
    }
}
