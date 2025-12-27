#pragma once
#include "../GumballMachine/IGumballMachine.h"
#include "IState.h"

#include <iostream>

class SoldOutState : public IState
{
public:
	explicit SoldOutState(IGumballMachine& gumballMachine)
		: m_gumballMachine(gumballMachine)
	{
	}

	void InsertQuarter() override
	{
		std::cout << "You can't insert a quarter, the machine is sold out\n";
	}

	void EjectQuarter() override
	{
		if (m_gumballMachine.GetQuarterCount() > 0)
		{
			std::cout << m_gumballMachine.GetQuarterCount() << " quarter(s) returned\n";
			m_gumballMachine.RemoveAllQuarters();
		}
		else
		{
			std::cout << "You can't eject, you haven't inserted a quarter yet\n";
		}
	}

	void TurnCrank() override
	{
		std::cout << "You turned but there's no gumballs\n";
	}

	void Dispense() override
	{
		std::cout << "No gumball dispensed\n";
	}
	void Refill(const unsigned count) override
	{
		if (count <= 0)
		{
			return;
		}
		m_gumballMachine.AddBalls(count);

		if (m_gumballMachine.GetQuarterCount() > 0)
		{
			if (m_gumballMachine.GetQuarterCount() == m_gumballMachine.MAX_PENNIES)
			{
				m_gumballMachine.SetMaxQuartersState();
			}
			else
			{
				m_gumballMachine.SetHasQuarterState();
			}
		}
		else
		{
			m_gumballMachine.SetNoQuarterState();
		}
	}

	std::string ToString() const override
	{
		return "sold out";
	}

private:
	IGumballMachine& m_gumballMachine;
};