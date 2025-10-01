#pragma once

#include <fstream>

class StreamValidator
{
public:
	static void AssertStreamIsGood(const std::ostream& output)
	{
		if (output.bad())
		{
			throw std::ios_base::failure("Failed to open output");
		}
	}

	static void AssertSizeIsNotNegative(const std::streamsize& size)
	{
		if (size < 0)
		{
			throw std::invalid_argument("Size cannot be negative");
		}
	}

	static void AssertStreamIsNotFail(const std::ostream& output)
	{
		if (output.fail())
		{
			throw std::ios_base::failure("Failed to write byte to output");
		}
	}

	static void AssertSourceIsNotEmpty(const void* srcData, const std::streamsize size)
	{
		if (srcData == nullptr && size > 0)
		{
			throw std::invalid_argument("Source data is null");
		}
	}
};