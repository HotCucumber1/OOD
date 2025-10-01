#pragma once

#include "../Input/DecompressionDecorator.h"
#include "../Input/DecryptDecorator.h"
#include "../Input/InputStreamInterface.h"

#include <memory>

enum class InputDecoratorType
{
	Decrypt,
	Decompress,
};

class InputDecoratorFactory
{
public:
	static std::unique_ptr<InputStreamInterface> CreateDecorator(
		const InputDecoratorType type,
		std::unique_ptr<InputStreamInterface> component,
		uint8_t cipherShift)
	{
		switch (type)
		{
		case InputDecoratorType::Decrypt:
			return std::make_unique<DecryptDecorator>(std::move(component), cipherShift);
		// case InputDecoratorType::Decompress:
		// 	return std::make_unique<DecompressionDecorator>(std::move(component));
		default:
			return component;
		}
	}
};