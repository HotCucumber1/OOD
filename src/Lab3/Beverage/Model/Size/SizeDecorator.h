#pragma once

#include "../BeverageInterface.h"

class SizeDecorator : public BeverageInterface
{
public:
    std::string GetDescription() const override
	{
		return m_beverage->GetDescription() + ' ' + GetSizeDescription();
	}

	double GetCost() const override
	{
		return m_beverage->GetCost() + GetSizeAddCost();
	}

	virtual std::string GetSizeDescription() const = 0;
	virtual double GetSizeAddCost() const = 0;

protected:
    explicit SizeDecorator(IBeveragePtr&& beverage)
        : m_beverage(std::move(beverage))
    {
    }

private:
    IBeveragePtr m_beverage;
};