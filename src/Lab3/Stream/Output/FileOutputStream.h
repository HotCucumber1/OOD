#pragma once

#include "OutputStreamInterface.h"

class FileOutputStream : public OutputStreamInterface
{
public:
	explicit FileOutputStream(std::ostream& output);

	void WriteByte(uint8_t data) override;

	void WriteBlock(const void* srcData, std::streamsize size) override;

	void Close() override;

private:
	void AssertStreamIsOpen() const;

private:
	std::ostream& m_output;
	bool m_isClosed = false;
};
