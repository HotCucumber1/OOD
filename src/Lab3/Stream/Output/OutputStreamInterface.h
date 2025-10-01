#pragma once

#include <iostream>
#include <memory>

class OutputStreamInterface
{
public:
	virtual void WriteByte(uint8_t data) = 0;

	virtual void WriteBlock(const void* srcData, std::streamsize size) = 0;

	virtual void Close() = 0;

	virtual ~OutputStreamInterface() = default;
};

using OutStreamPtr = std::unique_ptr<OutputStreamInterface>;