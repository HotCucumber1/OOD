#include "../../../src/Lab8/GumballMachine/GumballMachine/GumballMachine.h"
#include <catch2/catch_all.hpp>
#include <iostream>
#include <sstream>

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

TEST_CASE("GumballMachine initial state")
{
	SECTION("Machine with balls starts in NoQuarterState")
	{
		GumballMachine machine(5);
		auto output = machine.ToString();

		REQUIRE(output.find("Inventory: 5 gumballs") != std::string::npos);
		REQUIRE(output.find("Machine is waiting for quarter") != std::string::npos);
	}

	SECTION("Empty machine starts in SoldOutState")
	{
		GumballMachine machine(0);
		auto output = machine.ToString();

		REQUIRE(output.find("Inventory: 0 gumballs") != std::string::npos);
		REQUIRE(output.find("Machine is sold out") != std::string::npos);
	}

	SECTION("Machine with 1 ball uses singular form")
	{
		GumballMachine machine(1);
		auto output = machine.ToString();

		REQUIRE(output.find("Inventory: 1 gumball") != std::string::npos);
		REQUIRE(output.find("gumballs") == std::string::npos);
	}
}

TEST_CASE("NoQuarterState behavior")
{
	SECTION("Insert quarter in NoQuarterState transitions to HasQuarterState")
	{
		GumballMachine machine(5);
		OutputCapture capture;

		machine.InsertQuarter();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You inserted a quarter") != std::string::npos);
	}

	SECTION("Eject quarter in NoQuarterState does nothing")
	{
		GumballMachine machine(5);
		OutputCapture capture;

		machine.EjectQuarter();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You haven't inserted a quarter") != std::string::npos);
	}

	SECTION("Turn crank in NoQuarterState does nothing")
	{
		GumballMachine machine(5);
		OutputCapture capture;

		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You turned but there's no quarter") != std::string::npos);
	}

	SECTION("Dispense in NoQuarterState does nothing")
	{
		GumballMachine machine(5);
		OutputCapture capture;

		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You need to pay first") != std::string::npos);
	}
}

TEST_CASE("HasQuarterState behavior")
{
	GumballMachine machine(3);
	OutputCapture capture;

	machine.InsertQuarter();
	capture.Clear();

	SECTION("Insert another quarter in HasQuarterState")
	{
		machine.InsertQuarter();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You can't insert another quarter") != std::string::npos);
	}

	SECTION("Eject quarter in HasQuarterState returns quarter")
	{
		machine.EjectQuarter();
		auto output = capture.GetOutput();

		REQUIRE(output.find("Quarter returned") != std::string::npos);

		capture.Clear();
		machine.EjectQuarter();
		output = capture.GetOutput();
		REQUIRE(output.find("You haven't inserted a quarter") != std::string::npos);
	}

	SECTION("Turn crank in HasQuarterState transitions to SoldState")
	{
		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You turned...") != std::string::npos);
		REQUIRE(output.find("A gumball comes rolling out the slot...") != std::string::npos);
	}
}

TEST_CASE("SoldState behavior")
{
	SECTION("Dispense transitions to NoQuarterState when balls remain")
	{
		GumballMachine machine(2);
		OutputCapture capture;

		machine.InsertQuarter();
		capture.Clear();
		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("A gumball comes rolling out the slot...") != std::string::npos);

		capture.Clear();
		machine.EjectQuarter();
		output = capture.GetOutput();
		REQUIRE(output.find("You haven't inserted a quarter") != std::string::npos);
	}

	SECTION("Dispense transitions to SoldOutState when last ball sold")
	{
		GumballMachine machine(1);
		OutputCapture capture;

		machine.InsertQuarter();
		capture.Clear();
		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("A gumball comes rolling out the slot...") != std::string::npos);
		REQUIRE(output.find("Oops, out of gumballs") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		output = capture.GetOutput();
		REQUIRE(output.find("You can't insert a quarter, the machine is sold out") != std::string::npos);
	}
}

TEST_CASE("SoldOutState behavior")
{
	SECTION("Empty machine starts in SoldOutState")
	{
		GumballMachine machine(0);
		OutputCapture capture;

		machine.InsertQuarter();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You can't insert a quarter, the machine is sold out") != std::string::npos);
	}

	SECTION("Eject quarter in SoldOutState")
	{
		GumballMachine machine(0);
		OutputCapture capture;

		machine.EjectQuarter();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You can't eject, you haven't inserted a quarter yet") != std::string::npos);
	}

	SECTION("Turn crank in SoldOutState")
	{
		GumballMachine machine(0);
		OutputCapture capture;

		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You turned but there's no gumballs") != std::string::npos);
	}
}

TEST_CASE("Complete use cases")
{
	SECTION("Normal purchase flow")
	{
		GumballMachine machine(2);
		OutputCapture capture;

		machine.InsertQuarter();
		REQUIRE(capture.GetOutput().find("You inserted a quarter") != std::string::npos);

		capture.Clear();
		machine.TurnCrank();
		auto output = capture.GetOutput();
		REQUIRE(output.find("You turned...") != std::string::npos);
		REQUIRE(output.find("A gumball comes rolling out the slot...") != std::string::npos);

		REQUIRE(machine.ToString().find("Inventory: 1 gumball") != std::string::npos);

		capture.Clear();
		machine.TurnCrank();
		REQUIRE(capture.GetOutput().find("You turned but there's no quarter") != std::string::npos);
	}

	SECTION("Purchase with quarter ejection")
	{
		GumballMachine machine(2);
		OutputCapture capture;

		machine.InsertQuarter();

		capture.Clear();
		machine.EjectQuarter();
		REQUIRE(capture.GetOutput().find("Quarter returned") != std::string::npos);

		capture.Clear();
		machine.TurnCrank();
		REQUIRE(capture.GetOutput().find("You turned but there's no quarter") != std::string::npos);
	}

	SECTION("Sell all gumballs")
	{
		GumballMachine machine(2);
		OutputCapture capture;

		machine.InsertQuarter();
		capture.Clear();
		machine.TurnCrank();

		machine.InsertQuarter();
		capture.Clear();
		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("A gumball comes rolling out the slot...") != std::string::npos);
		REQUIRE(output.find("Oops, out of gumballs") != std::string::npos);

		REQUIRE(machine.ToString().find("Inventory: 0 gumballs") != std::string::npos);
		REQUIRE(machine.ToString().find("Machine is sold out") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		REQUIRE(capture.GetOutput().find("You can't insert a quarter, the machine is sold out") != std::string::npos);
	}

	SECTION("Multiple operations in different states")
	{
		GumballMachine machine(3);
		OutputCapture capture;

		machine.EjectQuarter();
		REQUIRE(capture.GetOutput().find("You haven't inserted a quarter") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		REQUIRE(capture.GetOutput().find("You inserted a quarter") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		REQUIRE(capture.GetOutput().find("You can't insert another quarter") != std::string::npos);

		capture.Clear();
		machine.EjectQuarter();
		REQUIRE(capture.GetOutput().find("Quarter returned") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		REQUIRE(capture.GetOutput().find("You inserted a quarter") != std::string::npos);

		capture.Clear();
		machine.TurnCrank();
		REQUIRE(capture.GetOutput().find("A gumball comes rolling out the slot...") != std::string::npos);

		REQUIRE(machine.ToString().find("Inventory: 2 gumballs") != std::string::npos);
	}
}

TEST_CASE("Edge cases")
{
	SECTION("Insert quarter into empty machine")
	{
		GumballMachine machine(0);
		OutputCapture capture;

		machine.InsertQuarter();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You can't insert a quarter, the machine is sold out") != std::string::npos);
	}

	SECTION("Eject from empty machine")
	{
		GumballMachine machine(0);
		OutputCapture capture;

		machine.EjectQuarter();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You can't eject, you haven't inserted a quarter yet") != std::string::npos);
	}

	SECTION("Turn crank on empty machine")
	{
		GumballMachine machine(0);
		OutputCapture capture;

		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You turned but there's no gumballs") != std::string::npos);
	}

	SECTION("Try to operate after machine is empty")
	{
		GumballMachine machine(1);
		OutputCapture capture;

		machine.InsertQuarter();
		capture.Clear();
		machine.TurnCrank();

		capture.Clear();
		machine.InsertQuarter();
		REQUIRE(capture.GetOutput().find("You can't insert a quarter, the machine is sold out") != std::string::npos);

		capture.Clear();
		machine.EjectQuarter();
		REQUIRE(capture.GetOutput().find("You can't eject, you haven't inserted a quarter yet") != std::string::npos);

		capture.Clear();
		machine.TurnCrank();
		REQUIRE(capture.GetOutput().find("You turned but there's no gumballs") != std::string::npos);
	}
}
