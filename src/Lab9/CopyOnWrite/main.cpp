#include "Drawer.h"
#include "Image/Image.h"
#include "Image/Point.h"

#include <fstream>
#include <iostream>

std::vector<Point> GetRobot();
std::vector<Point> GetBorders(int width, int height);
void DrawSmile(ImageInterface& img);
void DrawRobot(ImageInterface& image);
void DrawCircle(ImageInterface& image);
bool SaveToPPM(const ImageInterface& image, const std::string& filename);

void DrawInConsole()
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


void DrawInPPM()
{
	constexpr int size = 16;
	Image image(size, size);

	const uint32_t pixels[16][16] = {
		{ 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB },
		{ 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB },
		{ 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB },
		{ 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB },
		{ 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x9E6B4B, 0x9E6B4B, 0x9E6B4B, 0x9E6B4B, 0x9E6B4B, 0x9E6B4B, 0x9E6B4B, 0x9E6B4B, 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x87CEEB },
		{ 0x87CEEB, 0x87CEEB, 0x87CEEB, 0x9E6B4B, 0x5C4033, 0xD8D8D8, 0x5C4033, 0x8B4513, 0x5C4033, 0xD8D8D8, 0x5C4033, 0x8B4513, 0x9E6B4B, 0x87CEEB, 0x87CEEB, 0x87CEEB },
		{ 0x87CEEB, 0x87CEEB, 0x9E6B4B, 0xD4B48C, 0x8B4513, 0x5C4033, 0x8B4513, 0x5C4033, 0x8B4513, 0x5C4033, 0x8B4513, 0x5C4033, 0xD4B48C, 0x9E6B4B, 0x87CEEB, 0x87CEEB },
		{ 0x87CEEB, 0x9E6B4B, 0xD4B48C, 0xD8D8D8, 0x8B4513, 0x5C4033, 0xD8D8D8, 0x5C4033, 0xD8D8D8, 0x5C4033, 0xD8D8D8, 0x5C4033, 0xD8D8D8, 0xD4B48C, 0x9E6B4B, 0x87CEEB },
		{ 0x87CEEB, 0x9E6B4B, 0x9E6B4B, 0x8B4513, 0x8B4513, 0x5C4033, 0x8B4513, 0x5C4033, 0x8B4513, 0x5C4033, 0x8B4513, 0x5C4033, 0x8B4513, 0x9E6B4B, 0x9E6B4B, 0x87CEEB },
		{ 0x87CEEB, 0x87CEEB, 0xC2B280, 0xC2B280, 0xC2B280, 0xC2B280, 0xC2B280, 0xC2B280, 0xC2B280, 0xC2B280, 0xC2B280, 0xC2B280, 0xC2B280, 0xC2B280, 0x87CEEB, 0x87CEEB },
		{ 0x8B7355, 0xC2B280, 0xA0522D, 0xC2B280, 0xA0522D, 0xC2B280, 0xA0522D, 0xC2B280, 0xA0522D, 0xC2B280, 0xA0522D, 0xC2B280, 0xA0522D, 0xC2B280, 0xC2B280, 0x8B7355 },
		{ 0x8B7355, 0x8B7355, 0x8B4513, 0x8B4513, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B4513, 0x8B4513, 0x8B7355, 0x8B7355 },
		{ 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355 },
		{ 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355 },
		{ 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355 },
		{ 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355, 0x8B7355 }
	};

	for (int y = 0; y < size; ++y)
	{
		for (int x = 0; x < size; ++x)
		{
			image.SetPixel(x, y, pixels[y][x]);
		}
	}

	if (SaveToPPM(image, "output.ppm"))
	{
		std::cout << "Изображение сохранено в output.ppm" << std::endl;
	}
	else
	{
		std::cerr << "Ошибка сохранения файла" << std::endl;
	}
}

int main()
{
	try
	{
		// DrawInConsole();
		DrawInPPM();
	}
	catch (const std::exception& e)
	{
		std::cerr << e.what() << std::endl;
		return 1;
	}
}

bool SaveToPPM(const ImageInterface& image, const std::string& filename)
{
	std::ofstream file(filename, std::ios::binary);
	if (!file.is_open())
	{
		return false;
	}

	const Size size = image.GetSize();

	file << "P6\n";
	file << size.width << " " << size.height << "\n";
	file << "255\n";

	for (unsigned y = 0; y < size.height; ++y)
	{
		for (unsigned x = 0; x < size.width; ++x)
		{
			const uint32_t color = image.GetPixel(x, y);

			const auto r = (color >> 16) & 0xFF;
			const auto g = (color >> 8) & 0xFF;
			const auto b = color & 0xFF;

			file.write(reinterpret_cast<const char*>(&r), 1);
			file.write(reinterpret_cast<const char*>(&g), 1);
			file.write(reinterpret_cast<const char*>(&b), 1);
		}
	}

	file.close();
	return true;
}

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
	Drawer::DrawLine(img, 5, 4, 15, 4, 'o'); // Верх
	Drawer::DrawLine(img, 5, 12, 15, 12, 'o'); // Низ
	Drawer::DrawLine(img, 4, 5, 4, 11, 'o'); // Лево
	Drawer::DrawLine(img, 16, 5, 16, 11, 'o'); // Право

	// Глаза
	Drawer::DrawLine(img, 7, 6, 8, 6, '0'); // Левый глаз
	Drawer::DrawLine(img, 12, 6, 13, 6, '0'); // Правый глаз

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
	const Point circleCenter = { 10, 10 };
	Drawer::FillCircle(image, circleCenter, 4, '#');
	Drawer::DrawCircle(image, circleCenter, 7, '#');
}