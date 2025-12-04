#include "../../../src/Lab8/GumballMachine/GumballMachine/GumballMachine.h"

#include <catch2/catch_all.hpp>

class OutputCapture
{
public:
	OutputCapture()
		: m_oldBuf(std::cout.rdbuf(m_buffer.rdbuf()))
	{
	}

	~OutputCapture() { std::cout.rdbuf(m_oldBuf); }

	std::string GetOutput() const
	{
		return m_buffer.str();
	}

	void Clear()
	{
		m_buffer.str("");
	}

private:
	std::stringstream m_buffer;
	std::streambuf* m_oldBuf;
};

TEST_CASE("Empty gumball machine")
{
	SECTION("Eject quarter")
	{
		const OutputCapture capture;
		const GumballMachine gumballMachine(0);

		gumballMachine.EjectQuarter();
		REQUIRE(capture.GetOutput() == "You can't eject, you haven't inserted a quarter yet\n");
	}

	SECTION("Insert quarter")
	{
		const OutputCapture capture;
		const GumballMachine gumballMachine(0);

		gumballMachine.InsertQuarter();
		REQUIRE(capture.GetOutput() == "You can't insert a quarter, the machine is sold out\n");
	}

	SECTION("TurnCrank")
	{
		const OutputCapture capture;
		const GumballMachine gumballMachine(0);

		gumballMachine.TurnCrank();
		REQUIRE(capture.GetOutput() == "You turned but there's no gumballs\nNo gumball dispensed\n");
	}
}


TEST_CASE("Not empty gumball machine without money")
{
	SECTION("Eject quarter")
	{
		const OutputCapture capture;
		const GumballMachine gumballMachine(10);

		gumballMachine.EjectQuarter();
		REQUIRE(capture.GetOutput() == "You haven't inserted a quarter\n");
	}

	SECTION("Insert quarter")
	{
		const OutputCapture capture;
		const GumballMachine gumballMachine(10);

		gumballMachine.InsertQuarter();
		REQUIRE(capture.GetOutput() == "You inserted a quarter\n");
	}

	SECTION("TurnCrank")
	{
		const OutputCapture capture;
		const GumballMachine gumballMachine(10);

		gumballMachine.TurnCrank();
		REQUIRE(capture.GetOutput() == "You turned but there's no quarter\nYou need to pay first\n");
	}
}


TEST_CASE("Not empty gumball machine with money")
{
	SECTION("Eject quarter")
	{
		const OutputCapture capture;
		const GumballMachine gumballMachine(10);

		gumballMachine.InsertQuarter();
		gumballMachine.EjectQuarter();
		REQUIRE(capture.GetOutput() == "You inserted a quarter\nQuarter returned\n");
	}

	SECTION("Insert quarter")
	{
		const OutputCapture capture;
		const GumballMachine gumballMachine(10);

		gumballMachine.InsertQuarter();
		gumballMachine.InsertQuarter();
		REQUIRE(capture.GetOutput() == "You inserted a quarter\nYou can't insert another quarter\n");
	}

	SECTION("TurnCrank")
	{
		const OutputCapture capture;
		const GumballMachine gumballMachine(10);

		gumballMachine.InsertQuarter();
		gumballMachine.TurnCrank();
		REQUIRE(capture.GetOutput() == "You inserted a quarter\nYou turned...\nA gumball comes rolling out the slot...\n");
	}
}

