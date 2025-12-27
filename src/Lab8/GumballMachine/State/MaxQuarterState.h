#pragma once
#include "../GumballMachine/IGumballMachine.h"
#include "IState.h"

#include <iostream>

class MaxQuarterState : public IState
{
public:
	explicit MaxQuarterState(IGumballMachine& gumballMachine)
		: m_gumballMachine(gumballMachine)
	{
	}

	void InsertQuarter() override
	{
		std::cout << "You can't insert another quarter\n";
	}

	void EjectQuarter() override
	{
		std::cout << "5 quarters returned\n";
		m_gumballMachine.RemoveAllQuarters();
		m_gumballMachine.SetNoQuarterState();
	}

	void TurnCrank() override
	{
		std::cout << "You turned...\n";
		m_gumballMachine.SetSoldState();
	}

	void Dispense() override
	{
		std::cout << "No gumball dispensed\n";
	}

	void Refill(const unsigned count) override
	{
		if (count > 0)
		{
			m_gumballMachine.AddBalls(count);
		}
	}

	std::string ToString() const override
	{
		return "waiting for turn of crank";
	}

private:
	IGumballMachine& m_gumballMachine;
};