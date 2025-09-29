#pragma once

#include "TeaTypeDecorator.h"

class LyunCzinTea : public TeaTypeDecorator
{
public:
	explicit LyunCzinTea(IBeveragePtr&& beverage)
		: TeaTypeDecorator(std::move(beverage))
	{
	}

	std::string GetTypeDescription() const override
	{
		return "Lyun czin";
	}
};
