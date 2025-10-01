#include "FileOutputStream.h"
#include "../Validator/StreamValidator.h"


FileOutputStream::FileOutputStream(std::ostream& output)
	: m_output(output)
{
	StreamValidator::AssertStreamIsGood(m_output);
}

void FileOutputStream::WriteByte(const uint8_t data)
{
	AssertStreamIsOpen();
	StreamValidator::AssertStreamIsGood(m_output);

	m_output.put(static_cast<char>(data));

	StreamValidator::AssertStreamIsNotFail(m_output);
}

void FileOutputStream::WriteBlock(const void* srcData, const std::streamsize size)
{
	AssertStreamIsOpen();
	StreamValidator::AssertStreamIsGood(m_output);
	StreamValidator::AssertSizeIsNotNegative(size);

	if (size == 0)
	{
		return;
	}
	if (srcData == nullptr)
	{
		throw std::runtime_error("Source data pointer is null");
	}

	m_output.write(static_cast<const char*>(srcData), size);

	StreamValidator::AssertStreamIsNotFail(m_output);
}

void FileOutputStream::Close()
{
	if (!m_isClosed)
	{
		m_output.flush();
		m_isClosed = true;
	}
}

void FileOutputStream::AssertStreamIsOpen() const
{
	if (m_isClosed)
	{
		throw std::ios_base::failure("Stream is closed");
	}
}
