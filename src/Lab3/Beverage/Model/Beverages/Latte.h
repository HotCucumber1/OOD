#pragma once

#include "Coffee.h"

class Latte : public Coffee
{
public:
	Latte() 
		:Coffee("Latte") 
	{}

	double GetCost() const override 
	{
		return 90; 
	}
};