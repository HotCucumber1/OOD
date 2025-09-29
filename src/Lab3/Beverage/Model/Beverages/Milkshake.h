#pragma once

#include "Beverage.h"

class Milkshake : public Beverage
{
public:
	Milkshake() 
		:Beverage("Milkshake") 
	{}

	double GetCost() const override 
	{ 
		return 80; 
	}
};