#pragma once

#include "CondimantDecorator.h"

class Lemon : public CondimentDecorator
{
public:
	Lemon(IBeveragePtr && beverage, unsigned quantity = 1)
		: CondimentDecorator(std::move(beverage))
		, m_quantity(quantity)
	{}

protected:
	double GetCondimentCost()const override
	{
		return 10.0 * m_quantity;
	}
	std::string GetCondimentDescription()const override
	{
		return "Lemon x " + std::to_string(m_quantity);
	}
private:
	unsigned m_quantity;
};