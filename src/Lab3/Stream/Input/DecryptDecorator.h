#pragma once

#include "../Cipher/Cipher.h"
#include "InputStreamInterface.h"

class DecryptDecorator : public InputStreamInterface
{
public:
	DecryptDecorator(InStreamPtr&& input, const uint8_t shift)
		: m_ciper(shift)
		, m_input(std::move(input))
	{
	}

	bool IsEOF() const override;

	uint8_t ReadByte() override;

	std::streamsize ReadBlock(void* dstBuffer, std::streamsize size) override;

private:
	Cipher m_ciper;
	InStreamPtr m_input;
};
