#pragma once

#include "TeaTypeDecorator.h"

class DyanHunTea : public TeaTypeDecorator
{
public:
	explicit DyanHunTea(IBeveragePtr&& beverage)
		: TeaTypeDecorator(std::move(beverage))
	{
	}

	std::string GetTypeDescription() const override
	{
		return "Dyan hun";
	}
};
