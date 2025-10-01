#pragma once

#include "InputStreamInterface.h"

class FileInputStream : public InputStreamInterface
{
public:
	explicit FileInputStream(std::istream& input)
		: m_input(input)
	{
	};

	bool IsEOF() const override;

	uint8_t ReadByte() override;

	std::streamsize ReadBlock(void* dstBuffer, std::streamsize size) override;

private:
	std::istream& m_input;
};