#pragma once

#include "TeaTypeDecorator.h"

class ShuPuerTea : public TeaTypeDecorator
{
public:
	explicit ShuPuerTea(IBeveragePtr&& beverage)
		: TeaTypeDecorator(std::move(beverage))
	{
	}

	std::string GetTypeDescription() const override
	{
		return "Shu puer";
	}
};