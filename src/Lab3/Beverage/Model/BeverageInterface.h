#pragma once

#include <memory>
#include <string>

class BeverageInterface
{
public:
	virtual std::string GetDescription() const = 0;
	virtual double GetCost() const = 0;
	virtual ~BeverageInterface() = default;
};

using IBeveragePtr = std::unique_ptr<BeverageInterface>;
