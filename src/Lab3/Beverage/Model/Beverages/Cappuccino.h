#pragma once

#include "Coffee.h"

class Cappuccino : public Coffee
{
public:
	Cappuccino()
		: Coffee("Cappuccino")
	{
	}

	double GetCost() const override
	{
		return 80;
	}
};