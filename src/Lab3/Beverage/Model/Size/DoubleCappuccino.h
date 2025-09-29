#pragma once

#include "SizeDecorator.h"

class DoubleCappuccino : public SizeDecorator
{
public:
	explicit DoubleCappuccino(IBeveragePtr&& beverage)
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