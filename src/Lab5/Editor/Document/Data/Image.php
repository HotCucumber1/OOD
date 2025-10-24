<?php
declare(strict_types=1);

namespace App\Lab5\Editor\Document\Data;

class Image implements ImageInterface
{
    private \GdImage $image;

    public function __construct(
        private readonly string $path,
        private int             $width,
        private int             $height,
    )
    {
        $this->loadImage();
    }

    public function __destruct()
    {
        if (isset($this->image))
        {
            imagedestroy($this->image);
        }
    }

    public function getImage(): ?ImageInterface
    {
        return $this;
    }

    public function getParagraph(): ?ParagraphInterface
    {
        return null;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function resize(int $width, int $height): void
    {
        $newImage = imagecreatetruecolor($width, $height);
        $this->assertImageCreated($newImage);

        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        $transparent = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
        imagefill($newImage, 0, 0, $transparent);

        imagecopyresampled(
            $newImage, $this->image,
            0, 0, 0, 0,
            $width, $height,
            $this->width, $this->height
        );

        imagedestroy($this->image);
        $this->image = $newImage;
        $this->width = $width;
        $this->height = $height;

        $this->saveImage();
    }

    private function loadImage(): void
    {
        $extension = strtolower(pathinfo($this->path, PATHINFO_EXTENSION));

        $image = match ($extension)
        {
            'jpg', 'jpeg' => imagecreatefromjpeg($this->path),
            'png' => imagecreatefrompng($this->path),
            'gif' => imagecreatefromgif($this->path),
            'webp' => imagecreatefromwebp($this->path),
            default => throw new \RuntimeException("Unsupported image format: {$extension}"),
        };
        $this->assertImageCreated($image);
        $this->image = $image;
    }

    private function saveImage(): void
    {
        $extension = strtolower(pathinfo($this->path, PATHINFO_EXTENSION));
        $result = match ($extension)
        {
            'jpg', 'jpeg' => imagejpeg($this->image, $this->path, 90),
            'png' => imagepng($this->image, $this->path, 9),
            'gif' => imagegif($this->image, $this->path),
            'webp' => imagewebp($this->image, $this->path, 90),
            default => throw new \RuntimeException("Unsupported image format: {$extension}"),
        };

        if (!$result)
        {
            throw new \RuntimeException("Failed to save image: {$this->path}");
        }
    }

    private function assertImageCreated(\GdImage|false $image): void
    {
        if (!$image)
        {
            throw new \RuntimeException("Failed to load image: {$this->path}");
        }
    }
}
