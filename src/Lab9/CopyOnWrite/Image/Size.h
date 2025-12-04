#pragma once

struct Size
{
	explicit Size(
		const unsigned w = 0,
		const unsigned int h = 0)
		: width(w)
		, height(h)
	{
	}
	unsigned width;
	unsigned height;
};
