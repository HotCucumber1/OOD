#pragma once
#include "../GumballMachine/IGumballMachine.h"
#include "IState.h"

#include <iostream>

class SoldState : public IState
{
public:
	explicit SoldState(IGumballMachine& gumballMachine)
		: m_gumballMachine(gumballMachine)
	{
	}

	void InsertQuarter() override
	{
		std::cout << "Please wait, we're already giving you a gumball\n";
	}

	void EjectQuarter() override
	{
		std::cout << "Sorry you already turned the crank\n";
	}

	void TurnCrank() override
	{
		std::cout << "Turning twice doesn't get you another gumball\n";
	}

	void Dispense() override
	{
		m_gumballMachine.ReleaseBall();

		if (m_gumballMachine.GetBallCount() > 0)
		{
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
		else
		{
			std::cout << "Oops, out of gumballs!\n";
			if (m_gumballMachine.GetQuarterCount() > 0)
			{
				std::cout << "You can eject your remaining quarters\n";
				m_gumballMachine.SetSoldOutState();
			}
			else
			{
				m_gumballMachine.SetSoldOutState();
			}
		}
	}

	void Refill(unsigned count) override
	{
		std::cout << "Can't refill while dispensing a gumball\n";
	}

	std::string ToString() const override
	{
		return "delivering a gumball";
	}

private:
	IGumballMachine& m_gumballMachine;
};
