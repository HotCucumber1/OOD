<?php
declare(strict_types=1);

namespace App\Lab7\Slide\Canvas;

use App\Lab7\Slide\Common\Point;
use App\Lab7\Slide\Exception\InvalidHexColorException;

class Canvas implements CanvasInterface
{
    private const string HEX_FORMAT = '#%02x%02x%02x';
    private \GdImage $image;
    private int $strokeColor = 0;
    private int $fillColor = 0;
    private int $strokeWidth = 1;

    public function __construct(int $width, int $height)
    {
        $this->image = imagecreate($width, $height);
    }

    public function __destruct()
    {
        imagedestroy($this->image);
    }

    public function drawLine(Point $start, Point $end): void
    {
        imagesetthickness($this->image, $this->strokeWidth);
        imageline(
            $this->image,
            $start->x,
            $start->y,
            $end->x,
            $end->y,
            $this->strokeColor,
        );
    }

    public function strokeEllipse(Point $center, int $rx, int $ry): void
    {
        imagesetthickness($this->image, $this->strokeWidth);
        imageellipse(
            $this->image,
            $center->x,
            $center->y,
            $rx,
            $ry,
            $this->strokeColor,
        );
    }

    public function fillEllipse(Point $center, int $rx, int $ry): void
    {
        imagefilledellipse(
            $this->image,
            $center->x,
            $center->y,
            $rx,
            $ry,
            $this->fillColor,
        );
    }

    /**
     * @inheritDoc
     */
    public function strokePolygon(array $points): void
    {
        imagesetthickness($this->image, $this->strokeWidth);
        imagepolygon(
            $this->image,
            self::convertPointsToArray($points),
            count($points),
            $this->strokeColor,
        );
    }

    /**
     * @inheritDoc
     */
    public function fillPolygon(array $points): void
    {
        imagefilledpolygon(
            $this->image,
            self::convertPointsToArray($points),
            count($points),
            $this->fillColor,
        );
    }

    /**
     * @throws InvalidHexColorException
     */
    public function setFillColor(string $hex): void
    {
        $color = $this->convertHexToGdColor($hex);
        if ($color === false)
        {
            throw new InvalidHexColorException($hex);
        }
        $this->fillColor = $color;
    }

    /**
     * @throws InvalidHexColorException
     */
    public function setStrokeColor(string $hex): void
    {
        $color = $this->convertHexToGdColor($hex);
        if ($color === false)
        {
            throw new InvalidHexColorException($hex);
        }
        $this->strokeColor = $color;
    }

    public function setStrokeWidth(int $width): void
    {
        $this->strokeWidth = $width;
    }

    public function saveToFile(string $fileUrl): void
    {
        imagepng($this->image, $fileUrl);
        imagedestroy($this->image);
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
            return [...$acc, $point->x, $point->y];
        }, []);
    }
}