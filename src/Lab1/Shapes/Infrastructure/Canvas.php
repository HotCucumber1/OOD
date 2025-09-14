<?php
declare(strict_types=1);

namespace App\Lab1\Shapes\Infrastructure;

use App\Lab1\Shapes\Common\Point;
use App\Lab1\Shapes\Entity\CanvasInterface;
use App\Lab1\Shapes\Exception\InvalidHexColorException;

class Canvas implements CanvasInterface
{
    private const FONTS = [
        5 => 30,
        4 => 22,
        3 => 16,
        2 => 13,
        1 => 8,
    ];

    private const HEX_FORMAT = '#%02x%02x%02x';
    /**
     * @var Point[]
     */
    private array $polygonVertices = [];
    private int $color = 0;
    private Point $currentPoint;
    private \GdImage $image;

    public function __construct(
        private readonly string $fileUrl,
    )
    {
        $this->image = imagecreate(500, 500);
        $this->currentPoint = new Point(0, 0);
    }

    public function __destruct()
    {
        imagedestroy($this->image);
    }

    public function draw(): void
    {
        imagepng($this->image, $this->fileUrl);
    }

    public function moveTo(float $x, float $y): void
    {
        $this->currentPoint = new Point($x, $y);
        $this->polygonVertices = [$this->currentPoint];
    }

    public function lineTo(float $x, float $y): void
    {
        imageline(
            $this->image,
            (int)$this->currentPoint->x,
            (int)$this->currentPoint->y,
            (int)$x,
            (int)$y,
            $this->color,
        );
        $this->currentPoint = new Point($x, $y);
        $this->polygonVertices[] = $this->currentPoint;
    }

    /**
     * @throws InvalidHexColorException
     */
    public function setColor(string $hexColor): void
    {
        $color = $this->convertHexToGdColor($hexColor);
        if ($color === false)
        {
            throw new InvalidHexColorException($hexColor);
        }
        $this->color = $color;
    }

    public function drawRect(float $left, float $top, float $width, float $height): void
    {
        imagefilledrectangle(
            $this->image,
            (int)$left,
            (int)$top,
            (int)$left + (int)$width,
            (int)$top + (int)$height,
            $this->color,
        );
    }

    public function drawText(float $left, float $top, int $fontSize, string $text): void
    {
        imagestring(
            $this->image,
            self::getFontSize($fontSize),
            (int)$left,
            (int)$top,
            $text,
            $this->color,
        );
    }

    public function drawEllipse(float $cx, float $cy, float $rx, float $ry): void
    {
        imagefilledellipse(
            $this->image,
            (int)$cx,
            (int)$cy,
            (int)$rx,
            (int)$ry,
            $this->color,
        );
    }

    public function drawPolygon(): void
    {
        imagefilledpolygon(
            $this->image,
            self::convertPointsToArray($this->polygonVertices),
            count($this->polygonVertices),
            $this->color,
        );
    }

    private function convertHexToGdColor(string $hexColor): int|false
    {
        return imagecolorallocate(
            $this->image,
            ...sscanf($hexColor, self::HEX_FORMAT),
        );
    }

    /**
     * @param Point[] $points
     * @return int[]
     */
    private static function convertPointsToArray(array $points): array
    {
        return array_reduce($points, static function ($acc, Point $point): array {
            return [...$acc, ...$point->toArray()];
        }, []);
    }

    private static function getFontSize(int $fontSize): int
    {
        foreach (self::FONTS as $i => $font)
        {
            if ($fontSize > $font)
            {
                return $i;
            }
        }
        return 1;
    }
}