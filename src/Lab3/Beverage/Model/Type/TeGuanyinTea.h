#pragma once

#include "TeaTypeDecorator.h"

class TeGuanyinTea : public TeaTypeDecorator
{
public:
	explicit TeGuanyinTea(IBeveragePtr&& beverage)
		: TeaTypeDecorator(std::move(beverage))
	{
	}

	std::string GetTypeDescription() const override
	{
		return "Te guanyin";
	}
};