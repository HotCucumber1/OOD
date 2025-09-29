#pragma once

#include "CondimantDecorator.h"

class Cinnamon : public CondimentDecorator
{
public:
	Cinnamon(IBeveragePtr && beverage) 
		: CondimentDecorator(move(beverage)) 
	{}

protected:
	double GetCondimentCost()const override
	{
		return 20;
	}

	std::string GetCondimentDescription()const override
	{
		return "Cinnamon";
	}
};
