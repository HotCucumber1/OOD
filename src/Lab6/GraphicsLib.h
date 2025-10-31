#pragma once
#include <cstdint>
#include <iostream>

namespace graphics_lib
{
class ICanvas
{
public:
	virtual void SetColor(uint32_t rgbColor) = 0;
	virtual void MoveTo(int x, int y) = 0;
	virtual void LineTo(int x, int y) = 0;
	virtual ~ICanvas() = default;
};

class CCanvas final : public ICanvas
{
public:
	void SetColor(const uint32_t rgbColor) override
	{
		uint8_t r = (rgbColor >> 16) & 0xFF;
		uint8_t g = (rgbColor >> 8) & 0xFF;
		uint8_t b = rgbColor & 0xFF;

		std::cout << "SetColor (" << std::format("{:02X}{:02X}{:02X}", r, g, b) << ")" << std::endl;
	}

	void MoveTo(const int x, const int y) override
	{
		std::cout << "MoveTo (" << x << ", " << y << ")" << std::endl;
	}
	void LineTo(const int x, const int y) override
	{
		std::cout << "LineTo (" << x << ", " << y << ")" << std::endl;
	}
};
} // namespace graphics_lib
