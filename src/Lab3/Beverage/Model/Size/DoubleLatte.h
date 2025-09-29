#pragma once

#include "SizeDecorator.h"

class DoubleLatte : public SizeDecorator
{
public:
	explicit DoubleLatte(IBeveragePtr&& beverage)
		: SizeDecorator(std::move(beverage))
	{
	}

	double GetSizeAddCost() const override
	{
		return 40;
	}

	std::string GetSizeDescription() const override
	{
		return "double";
	}
};