#pragma once
#include "Size.h"

class ImageInterface
{
public:
	virtual char GetPixel(unsigned x, unsigned y) const = 0;

	virtual void SetPixel(unsigned x, unsigned y, char color) = 0;

	virtual Size GetSize() const = 0;

	virtual ~ImageInterface() = default;
};