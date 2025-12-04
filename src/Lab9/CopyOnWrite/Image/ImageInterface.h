#pragma once
#include "Size.h"

#include <cstdint>

class ImageInterface
{
public:
	virtual uint32_t GetPixel(unsigned x, unsigned y) const = 0;

	virtual void SetPixel(unsigned x, unsigned y, uint32_t color) = 0;

	virtual Size GetSize() const = 0;

	virtual ~ImageInterface() = default;
};