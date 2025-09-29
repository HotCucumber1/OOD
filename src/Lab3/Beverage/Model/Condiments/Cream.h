#pragma once
#include "CondimantDecorator.h"

class Cream : public CondimentDecorator
{
public:
	Cream(IBeveragePtr && beverage)
		: CondimentDecorator(std::move(beverage))
	{
	}

protected:
	double GetCondimentCost()const override
	{
		return 25;
	}

	std::string GetCondimentDescription()const override
	{
		return "Cream";
	}
};