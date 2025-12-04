#include "Image/Image.h"
#include "Image/Point.h"
#include "Drawer.h"

#include <iostream>

std::vector<Point> GetRobot()
{
	return {
		Point(9, 3), Point(10, 3),
		Point(8, 4), Point(9, 4), Point(10, 4), Point(11, 4),
		Point(8, 5), Point(9, 5), Point(10, 5), Point(11, 5),

		// Тело
		Point(9, 6), Point(10, 6),
		Point(9, 7), Point(10, 7),
		Point(9, 8), Point(10, 8),

		// Руки
		Point(7, 7), Point(8, 7), // левая рука
		Point(11, 7), Point(12, 7), // правая рука

		// Ноги
		Point(8, 9), Point(9, 9), // левая нога
		Point(10, 9), Point(11, 9) // правая нога
	};
}

std::vector<Point> GetBorders(const int width, const int height)
{
	std::vector<Point> borders;
	for (int i = 0; i < height; i++)
	{
		borders.emplace_back(0, i);
		borders.emplace_back(width - 1, i);
	}
	for (int i = 0; i < width; i++)
	{
		borders.emplace_back(i, 0);
		borders.emplace_back(i, height - 1);
	}
	return borders;
}

void DrawSmile(ImageInterface& img)
{
	Drawer::DrawLine(img, 5, 4, 15, 4, 'o');  // Верх
	Drawer::DrawLine(img, 5, 12, 15, 12, 'o'); // Низ
	Drawer::DrawLine(img, 4, 5, 4, 11, 'o');   // Лево
	Drawer::DrawLine(img, 16, 5, 16, 11, 'o'); // Право

	// Глаза
	Drawer::DrawLine(img, 7, 6, 8, 6, '0');    // Левый глаз
	Drawer::DrawLine(img, 12, 6, 13, 6, '0');  // Правый глаз

	// Рот (улыбка)
	Drawer::DrawLine(img, 7, 9, 13, 9, ')');
	Drawer::DrawLine(img, 8, 10, 12, 10, ')');

	// Тело (треугольник)
	Drawer::DrawLine(img, 10, 13, 5, 18, '/');
	Drawer::DrawLine(img, 10, 13, 15, 18, '\\');
	Drawer::DrawLine(img, 5, 18, 15, 18, '_');
}

void DrawRobot(ImageInterface& image)
{
	const auto robot = GetRobot();
	for (const auto& point : robot)
	{
		image.SetPixel(point.x, point.y, '#');
	}
}

void DrawCircle(ImageInterface& image)
{
	const Point circleCenter = {10, 10};
	Drawer::FillCircle(image, circleCenter, 4, '#');
	Drawer::DrawCircle(image, circleCenter, 7, '#');
}

int main()
{
	try
	{
		auto img = Image(20, 20);

		const auto borders = GetBorders(20, 20);
		const auto robot = GetRobot();

		for (const auto& point : borders)
		{
			img.SetPixel(point.x, point.y, '#');
		}

		// DrawRobot(img);

		// DrawCircle(img);

		DrawSmile(img);

		Drawer::Print(img);
	}
	catch (const std::exception& e)
	{
		std::cerr << e.what() << std::endl;
		return 1;
	}
}