#pragma once

#include "CondimantDecorator.h"

enum class SyrupType
{
	Chocolate,
	Maple
};

class Syrup : public CondimentDecorator
{
public:
	Syrup(IBeveragePtr&& beverage, SyrupType syrupType)
		: CondimentDecorator(std::move(beverage))
		, m_syrupType(syrupType)
	{
	}

protected:
	double GetCondimentCost() const override
	{
		return 15;
	}
	std::string GetCondimentDescription() const override
	{
		return std::string(m_syrupType == SyrupType::Chocolate
			? "Chocolate"
			: "Maple") + " syrup";
	}

private:
	SyrupType m_syrupType;
};