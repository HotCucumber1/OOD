#pragma once
#include "CondimantDecorator.h"

class ChocolateBar : public CondimentDecorator
{
public:
	ChocolateBar(IBeveragePtr&& beverage, int count = 1)
		: CondimentDecorator(std::move(beverage))
		, m_count(count)
	{
	}

protected:
	double GetCondimentCost() const override
	{
		return m_count * 10;
	}

	std::string GetCondimentDescription() const override
	{
		return "Chocolate bar " + std::to_string(m_count) + "pieces";
	}

private:
	int m_count;
};