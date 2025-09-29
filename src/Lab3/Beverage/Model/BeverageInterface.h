#pragma once

#include <string>
#include <memory>


class BeverageInterface
{
public:
	virtual std::string GetDescription() const = 0;
	virtual double GetCost()const = 0;
	virtual ~BeverageInterface() = default;
};

typedef std::unique_ptr<BeverageInterface> IBeveragePtr;
