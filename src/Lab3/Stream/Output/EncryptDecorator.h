#pragma once

#include "../Cipher/Cipher.h"
#include "OutputStreamInterface.h"

class EncryptDecorator : public OutputStreamInterface
{
public:
	EncryptDecorator(OutStreamPtr&& output, const uint8_t shift)
		: m_ciper(shift)
		, m_output(std::move(output))
	{
	}

	void WriteByte(uint8_t data) override;

	void WriteBlock(const void* srcData, std::streamsize size) override;

	void Close() override;

private:
	Cipher m_ciper;
	OutStreamPtr m_output;
};
