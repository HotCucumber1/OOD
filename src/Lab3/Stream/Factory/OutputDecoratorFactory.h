#pragma once

#include "../Output/CompressionDecorator.h"
#include "../Output/EncryptDecorator.h"
#include "../Output/OutputStreamInterface.h"
#include <memory>

enum class OutputDecoratorType
{
	Encrypt,
	Compress,
};

class OutputDecoratorFactory
{
public:
	static std::unique_ptr<OutputStreamInterface> CreateDecorator(
		const OutputDecoratorType type,
		std::unique_ptr<OutputStreamInterface> component,
		uint8_t cipherShift)
	{
		switch (type)
		{
		case OutputDecoratorType::Encrypt:
			return std::make_unique<EncryptDecorator>(std::move(component), cipherShift);
		// case OutputDecoratorType::Compress:
		// 	return std::make_unique<CompressionDecorator>(std::move(component));
		default:
			return component;
		}
	}
};