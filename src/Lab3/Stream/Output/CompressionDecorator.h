#pragma once

#include "../Output/OutputStreamInterface.h"

class CompressionDecorator : public OutputStreamInterface
{
public:
	explicit CompressionDecorator(OutStreamPtr&& output)
		: m_output(std::move(output))
	{
	}

	void WriteByte(uint8_t data) override;

	void WriteBlock(const void* srcData, std::streamsize size) override;

	void Close() override;

private:
	OutStreamPtr m_output;
};
