#pragma once
#include "Size.h"
#include <vector>

class Tile
{
	using Matrix = std::vector<std::vector<uint32_t>>;

public:
	Tile(const unsigned w, const unsigned h, const uint32_t c)
		: m_tileMatrix(h, std::vector(w, c))
		, m_size(w, h)
	{
		m_instanceCount++;
	}

	void SetPixel(const unsigned x, const unsigned y, const uint32_t c)
	{
		if (x >= m_size.width || y >= m_size.height)
		{
			return;
		}
		m_tileMatrix[y][x] = c;
	}

	uint32_t GetPixel(const unsigned x, const unsigned y) const
	{
		if (x >= m_size.width || y >= m_size.height)
		{
			return ' ';
		}
		return m_tileMatrix[y][x];
	}

	static int GetInstanceCount()
	{
		return m_instanceCount;
	}

	~Tile()
	{
		m_instanceCount--;
	}

private:
	static int m_instanceCount;

	Matrix m_tileMatrix;
	Size m_size;
};

int Tile::m_instanceCount = 0;