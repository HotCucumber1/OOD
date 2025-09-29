#pragma once

#include "Beverage.h"

class Tea : public Beverage
{
public:
	Tea() 
		:Beverage("Tea") 
	{}

	double GetCost() const override 
	{
		return 30; 
	}
};