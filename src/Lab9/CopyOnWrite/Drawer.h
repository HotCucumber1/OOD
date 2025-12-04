#pragma once
#include "Image/ImageInterface.h"

#include <iosfwd>
#include <iostream>

namespace Drawer
{
/**
 * Bresenham's line algorithm
 */
inline void DrawLine(
	ImageInterface& image,
	const int x1,
	const int y1,
	const int x2,
	const int y2,
	const char color)
{
	const int dx = abs(x2 - x1);
	const int dy = abs(y2 - y1);

	const int stepX = (x1 < x2) ? 1 : -1;
	const int stepY = (y1 < y2) ? 1 : -1;

	int error = dx - dy;
	int currentX = x1;
	int currentY = y1;

	image.SetPixel(currentX, currentY, color);
	while (currentX != x2 || currentY != y2)
	{
		const int error2 = error * 2;

		if (error2 > -dy)
		{
			error -= dy;
			currentX += stepX;
		}

		if (error2 < dx)
		{
			error += dx;
			currentY += stepY;
		}

		image.SetPixel(currentX, currentY, color);
	}
}

/**
 * Bresenham's circle algorithm
 */
inline void DrawCircle(
	ImageInterface& image,
	const Point center,
	const int radius,
	const char color)
{
	int x = 0;
	int y = radius;
	int delta = 3 - 2 * y;
	while (y >= x)
	{
		image.SetPixel(center.x + x, center.y + y, color);
		image.SetPixel(center.x + x, center.y - y, color);
		image.SetPixel(center.x - x, center.y + y, color);
		image.SetPixel(center.x - x, center.y - y, color);

		image.SetPixel(center.x + y, center.y + x, color);
		image.SetPixel(center.x + y, center.y - x, color);
		image.SetPixel(center.x - y, center.y + x, color);
		image.SetPixel(center.x - y, center.y - x, color);

		if (delta > 0)
		{
			y--;
			delta += 4 * (x - y) + 10;
		}
		else
		{
			delta += 4 * x + 6;
		}
		x++;
	}
}

/**
 * Bresenham's circle algorithm
 */
inline void FillCircle(
	ImageInterface& image,
	const Point center,
	const int radius,
	const char color)
{
	int x = 0;
	int y = radius;
	int delta = 3 - 2 * y;
	while (y >= x)
	{
		DrawLine(image, center.x - x, center.y + y, center.x + x, center.y + y, color);
		DrawLine(image, center.x - x, center.y - y, center.x + x, center.y - y, color);
		DrawLine(image, center.x - y, center.y + x, center.x + y, center.y + x, color);
		DrawLine(image, center.x - y, center.y - x, center.x + y, center.y - x, color);

		if (delta > 0)
		{
			y--;
			delta += 4 * (x - y) + 10;
		}
		else
		{
			delta += 4 * x + 6;
		}
		x++;
	}
}

inline void Print(
	const ImageInterface& image,
	std::ostream& output = std::cout)
{
	const auto imgSize = image.GetSize();
	for (int i = 0; i < imgSize.height; ++i)
	{
		for (int j = 0; j < imgSize.width; ++j)
		{
			output << image.GetPixel(j, i);
		}
		output << std::endl;
	}
	output << std::endl;
}
} // namespace Drawer