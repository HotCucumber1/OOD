#pragma once

#include "Beverage.h"

class Coffee : public Beverage
{
public:
	Coffee(const std::string& description = "Coffee")
		:Beverage(description) 
	{}

	double GetCost() const override 
	{
		return 60; 
	}
};
