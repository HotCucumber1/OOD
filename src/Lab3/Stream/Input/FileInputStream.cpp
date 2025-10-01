#include "FileInputStream.h"
#include "../Validator/StreamValidator.h"

#include <istream>

void AssertStreamIsGood(const std::istream& input)
{
	if (input.bad())
	{
		throw std::ios_base::failure("Failed to read block");
	}
}

bool FileInputStream::IsEOF() const
{
	return m_input.peek() == EOF;
}

uint8_t FileInputStream::ReadByte()
{
	int byte = m_input.get();

	if (byte == EOF || m_input.fail())
	{
		throw std::ios_base::failure("Failed to read byte: end of file or I/O error");
	}

	return static_cast<uint8_t>(byte);
	// char byte;
	// m_input.get(byte);
	//
	// if (byte == EOF || m_input.fail())
	// {
	// 	throw std::ios_base::failure("Failed to read byte");
	// }
	// return byte;
}

std::streamsize FileInputStream::ReadBlock(void* dstBuffer, const std::streamsize size)
{
	StreamValidator::AssertSizeIsNotNegative(size);
	if (size == 0)
	{
		return 0;
	}
	if (dstBuffer == nullptr)
	{
		throw std::invalid_argument("Destination buffer cannot be null");
	}

	auto charBuffer = static_cast<char*>(dstBuffer);
	m_input.read(charBuffer, size);

	AssertStreamIsGood(m_input);
	return m_input.gcount();
}
