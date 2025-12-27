#pragma once
#include "../GumballMachine/IGumballMachine.h"
#include "IState.h"

#include <iostream>

class HasQuarterState : public IState
{
public:
	explicit HasQuarterState(IGumballMachine& gumballMachine)
		: m_gumballMachine(gumballMachine)
	{
	}

	void InsertQuarter() override
	{
		if (m_gumballMachine.GetQuarterCount() >= m_gumballMachine.MAX_PENNIES)
		{
			std::cout << "You can't insert another quarter\n";
			return;
		}
		m_gumballMachine.AddQuarter();
		std::cout << "You inserted a quarter. Total quarters: "
				  << m_gumballMachine.GetQuarterCount() << "\n";

		if (m_gumballMachine.GetQuarterCount() == m_gumballMachine.MAX_PENNIES)
		{
			m_gumballMachine.SetMaxQuartersState();
		}
	}

	void EjectQuarter() override
	{
		std::cout << "Quarter returned\n";
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
