#pragma once
#include <iostream>

namespace graphics_lib
{
class ICanvas
{
public:
	virtual void MoveTo(int x, int y) = 0;
	virtual void LineTo(int x, int y) = 0;
	virtual ~ICanvas() = default;
};

class CCanvas final : public ICanvas
{
public:
	void MoveTo(const int x, const int y) override
	{
		std::cout << "MoveTo (" << x << ", " << y << ")" << std::endl;
	}
	void LineTo(const int x, const int	y) override
	{
		std::cout << "LineTo (" << x << ", " << y << ")" << std::endl;
	}
};
} // namespace graphics_lib
