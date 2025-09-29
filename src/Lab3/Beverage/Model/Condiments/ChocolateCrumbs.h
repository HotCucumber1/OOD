#pragma once

#include "CondimantDecorator.h"

class ChocolateCrumbs : public CondimentDecorator
{
public:
	ChocolateCrumbs(IBeveragePtr&& beverage, const unsigned mass)
		: CondimentDecorator(std::move(beverage))
		, m_mass(mass)
	{
	}

	double GetCondimentCost() const override
	{
		return 2.0 * m_mass;
	}

	std::string GetCondimentDescription() const override
	{
		return "Chocolate crumbs " + std::to_string(m_mass) + "g";
	}

private:
	unsigned m_mass;
};