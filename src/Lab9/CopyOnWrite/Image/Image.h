#pragma once
#include "../CoW/CoW.h"
#include "ImageInterface.h"
#include "Tile.h"

#include <vector>

class Image : public ImageInterface
{
	static constexpr int TILE_SIZE = 10;

	using Matrix = std::vector<std::vector<CoW<Tile>>>;

public:
	static constexpr char DEFAULT_COLOR = ' ';

	Image(const unsigned width, const unsigned height)
		: m_size(width, height)
	{
		InitImage(width, height);
	}

	// Image(const std::string& sourceStr)
	// {
	// 	size_t columnsCount = 0;
	// 	std::string line;
	// 	std::stringstream stream(sourceStr);
	//
	// 	int row = 0;
	// 	while (std::getline(stream, line))
	// 	{
	// 		if (columnsCount == 0)
	// 		{
	// 			columnsCount = line.length();
	// 		}
	// 		for (int i = 0; i < columnsCount; i++)
	// 		{
	// 			m_
	// 		}
	//
	//
	//
	// 		row++;
	// 	}
	// }

	char GetPixel(const unsigned x, const unsigned y) const override
	{
		if (x >= m_size.width || y >= m_size.height)
		{
			return ' ';
		}
		const auto rowIndex = y / TILE_SIZE;
		const auto colIndex = x / TILE_SIZE;

		return m_tiles[rowIndex][colIndex]->GetPixel(
			x % TILE_SIZE,
			y % TILE_SIZE);
	}

	void SetPixel(const unsigned x, const unsigned y, const char color) override
	{
		if (x >= m_size.width || y >= m_size.height)
		{
			return;
		}
		const auto rowIndex = y / TILE_SIZE;
		const auto colIndex = x / TILE_SIZE;

		m_tiles[rowIndex][colIndex].Write()->SetPixel(
			x % TILE_SIZE,
			y % TILE_SIZE,
			color);
	}

	Size GetSize() const override
	{
		return m_size;
	}

private:
	void InitImage(const unsigned width, const unsigned height)
	{
		const auto tileRows = GetTilesCount(height);
		const auto tileColumns = GetTilesCount(width);

		m_tiles.reserve(tileRows);
		for (unsigned i = 0; i < tileRows; i++)
		{
			std::vector<CoW<Tile>> row;
			row.reserve(tileColumns);
			for (unsigned j = 0; j < tileColumns; j++)
			{
				row.emplace_back(TILE_SIZE, TILE_SIZE, ' ');
			}
			m_tiles.emplace_back(std::move(row));
		}
	}

	static unsigned GetTilesCount(const unsigned dimensionSize)
	{
		return (dimensionSize % TILE_SIZE == 0)
			? dimensionSize / TILE_SIZE
			: dimensionSize / TILE_SIZE + 1;
	}

	Size m_size;
	Matrix m_tiles;
};