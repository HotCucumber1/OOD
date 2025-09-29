#pragma once

#include "../BeverageInterface.h"

class TeaTypeDecorator : public BeverageInterface
{
public:
	std::string GetDescription() const override
	{
		return m_beverage->GetDescription() + ' ' + GetTypeDescription();
	}

	double GetCost() const override
	{
		return m_beverage->GetCost();
	}

	virtual std::string GetTypeDescription() const = 0;

protected:
	explicit TeaTypeDecorator(IBeveragePtr&& beverage)
		: m_beverage(std::move(beverage))
	{
	}

private:
	IBeveragePtr m_beverage;
};