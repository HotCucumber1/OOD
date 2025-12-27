#pragma once
#include <iostream>
#include <string>

class GumballMachineNaive
{
public:
	enum class State
	{
		SoldOut,
		NoQuarter,
		HasQuarter,
		MaxQuarters,
		Sold
	};

	explicit GumballMachineNaive(const unsigned numBalls)
		: m_count(numBalls)
	{
		if (m_count > 0)
		{
			m_state = State::NoQuarter;
		}
		else
		{
			m_state = State::SoldOut;
		}
	}

	void InsertQuarter()
	{
		switch (m_state)
		{
		case State::SoldOut:
			std::cout << "You can't insert a quarter, the machine is sold out\n";
			break;
		case State::NoQuarter:
			m_quarters = 1;
			m_state = State::HasQuarter;
			std::cout << "You inserted a quarter\n";
			break;
		case State::HasQuarter:
			if (m_quarters < 5)
			{
				m_quarters++;
				std::cout << "You inserted a quarter. Total quarters: " << m_quarters << "\n";
				if (m_quarters == 5)
				{
					m_state = State::MaxQuarters;
					std::cout << "You can't insert more than 5 quarters\n";
				}
			}
			break;
		case State::MaxQuarters:
			std::cout << "You can't insert more than 5 quarters\n";
			break;
		case State::Sold:
			std::cout << "Please wait, we're already giving you a gumball\n";
			break;
		}
	}

	void EjectQuarter()
	{
		switch (m_state)
		{
		case State::SoldOut:
			if (m_quarters > 0)
			{
				std::cout << "Quarter returned\n";
				m_quarters = 0;
			}
			else
			{
				std::cout << "You can't eject, you haven't inserted a quarter yet\n";
			}
			break;
		case State::NoQuarter:
			std::cout << "You haven't inserted a quarter\n";
			break;
		case State::HasQuarter:
		case State::MaxQuarters:
			std::cout << m_quarters << " quarter(s) returned\n";
			m_quarters = 0;
			m_state = State::NoQuarter;
			break;
		case State::Sold:
			std::cout << "Sorry, you already turned the crank\n";
			break;
		}
	}

	void TurnCrank()
	{
		switch (m_state)
		{
		case State::SoldOut:
			std::cout << "You turned but there's no gumballs\n";
			break;
		case State::NoQuarter:
			std::cout << "You turned but there's no quarter\n";
			break;
		case State::HasQuarter:
		case State::MaxQuarters:
			std::cout << "You turned...\n";
			m_state = State::Sold;
			Dispense();
			break;
		case State::Sold:
			std::cout << "Turning twice doesn't get you another gumball\n";
			break;
		}
	}

	void Refill(unsigned count)
	{
		m_count = count;
		if (m_count > 0)
		{
			if (m_quarters > 0)
			{
				if (m_quarters == 5)
					m_state = State::MaxQuarters;
				else
					m_state = State::HasQuarter;
			}
			else
			{
				m_state = State::NoQuarter;
			}
		}
		else
		{
			m_state = State::SoldOut;
		}
	}

	std::string ToString() const
	{
		std::string stateStr;
		switch (m_state)
		{
		case State::SoldOut:
			stateStr = "sold out";
			break;
		case State::NoQuarter:
			stateStr = "waiting for quarter(s)";
			break;
		case State::HasQuarter:
			stateStr = "has " + std::to_string(m_quarters) + " quarter(s)";
			break;
		case State::MaxQuarters:
			stateStr = "has maximum quarters (5)";
			break;
		case State::Sold:
			stateStr = "delivering a gumball";
			break;
		}

		return std::string(R"(
Mighty Gumball, Inc.
C++-enabled Standing Gumball Model #2024
Inventory: )")
			+ std::to_string(m_count) + " gumball" + (m_count != 1 ? "s" : "") + "\nQuarters: " + std::to_string(m_quarters) + "\nMachine is " + stateStr + "\n";
	}

private:
	void Dispense()
	{
		switch (m_state)
		{
		case State::Sold:
			if (m_count > 0)
			{
				std::cout << "A gumball comes rolling out the slot...\n";
				m_count--;
				m_quarters--;

				if (m_count == 0)
				{
					std::cout << "Oops, out of gumballs!\n";
					m_state = State::SoldOut;
				}
				else if (m_quarters > 0)
				{
					m_state = State::HasQuarter;
					if (m_quarters == 5)
						m_state = State::MaxQuarters;
				}
				else
				{
					m_state = State::NoQuarter;
				}
			}
			break;
		default:
			std::cout << "No gumball dispensed\n";
			break;
		}
	}

	State m_state = State::SoldOut;
	unsigned m_count = 0;
	unsigned m_quarters = 0;
};