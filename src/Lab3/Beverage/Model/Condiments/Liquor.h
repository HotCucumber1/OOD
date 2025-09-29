#pragma once
#include "CondimantDecorator.h"

enum class LiquorType
{
	Nut,
	Chocolate,
};

class Liquor : public CondimentDecorator
{
public:
	Liquor(IBeveragePtr&& beverage, LiquorType type)
		: CondimentDecorator(std::move(beverage))
		, m_type(type)
	{
	}

protected:
	double GetCondimentCost() const override
	{
		return 50;
	}

	std::string GetCondimentDescription() const override
	{
		return std::string(m_type == LiquorType::Nut
			? "Nut"
			: "Chocolate") + " liquor";
	}

private:
	LiquorType m_type;
};