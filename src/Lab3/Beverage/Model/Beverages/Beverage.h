#pragma once

#include <utility>

#include "../BeverageInterface.h"

class Beverage : public BeverageInterface
{
public:
	explicit Beverage(std::string  description)
		: m_description(std::move(description))
	{
	}

	std::string GetDescription() const final
	{
		return m_description;
	}

private:
	std::string m_description;
};
