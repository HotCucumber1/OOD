#pragma once
#include "InputStreamInterface.h"

class DecompressionDecorator : public InputStreamInterface
{
public:
	explicit DecompressionDecorator(InStreamPtr&& input)
		: m_input(std::move(input))
	{
	}

	bool IsEOF() const override;

	uint8_t ReadByte() override;

	std::streamsize ReadBlock(void* dstBuffer, std::streamsize size) override;


private:
	InStreamPtr m_input;
};
