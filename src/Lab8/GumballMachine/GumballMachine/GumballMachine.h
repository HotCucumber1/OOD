#pragma once
#include "../State/HasQuarterState.h"
#include "../State/IState.h"
#include "../State/MaxQuarterState.h"
#include "../State/NoQuarterState.h"
#include "../State/SoldOutState.h"
#include "../State/SoldState.h"
#include "IGumballMachine.h"

#include <format>
#include <memory>

class GumballMachine final : private IGumballMachine
{
public:
	explicit GumballMachine(const unsigned numBalls)
		: m_count(numBalls)
	{
		if (m_count > 0)
		{
			SetNoQuarterState();
		}
		else
		{
			SetSoldOutState();
		}
	}

	void EjectQuarter() const
	{
		m_currentState->EjectQuarter();
	}

	void InsertQuarter() const
	{
		m_currentState->InsertQuarter();
	}

	void TurnCrank() const
	{
		m_currentState->TurnCrank();
		m_currentState->Dispense();
	}

	std::string ToString() const
	{
		return std::format(R"(
Mighty Gumball, Inc.
C++-enabled Standing Gumball Model #2016
Inventory: {} gumball{}
Machine is {}
)",
			m_count, m_count != 1 ? "s" : "", m_currentState->ToString());
	}

private:
	unsigned GetBallCount() const override
	{
		return m_count;
	}

	unsigned GetQuarterCount() const override
	{
		return m_pennies;
	}

	void AddQuarter() override
	{
		if (m_pennies < 5)
		{
			m_pennies++;
		}
	}

	void RemoveOneQuarter() override
	{
		if (m_pennies > 0)
		{
			m_pennies--;
		}
	}

	void ReleaseBall() override
	{
		if (m_count != 0)
		{
			std::cout << "A gumball comes rolling out the slot...\n";
			--m_count;
			--m_pennies;
		}
	}

	void RemoveAllQuarters() override
	{
		m_pennies = 0;
	}

	void SetSoldOutState() override
	{
		m_currentState.reset(new SoldOutState(*this));
	}

	void SetNoQuarterState() override
	{
		m_currentState.reset(new NoQuarterState(*this));
	}

	void SetSoldState() override
	{
		m_currentState.reset(new SoldState(*this));
	}

	void SetHasQuarterState() override
	{
		m_currentState.reset(new HasQuarterState(*this));
	}

	void SetMaxQuartersState() override
	{
		m_currentState.reset(new MaxQuarterState(*this));
	}

	unsigned m_count = 0;
	unsigned m_pennies = 0;
	std::unique_ptr<IState> m_currentState;
};
