#pragma once

#include "../BeverageInterface.h"

class CondimentDecorator : public BeverageInterface
{
public:
	std::string GetDescription()const override
	{
		return m_beverage->GetDescription() + ", " + GetCondimentDescription();
	}

	double GetCost()const override
	{
		return m_beverage->GetCost() + GetCondimentCost();
	}

	virtual std::string GetCondimentDescription()const = 0;
	virtual double GetCondimentCost()const = 0;

protected:
	CondimentDecorator(IBeveragePtr && beverage)
		: m_beverage(move(beverage))
	{
	}
private:
	IBeveragePtr m_beverage;
};
