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
		REQUIRE(output.find("waiting for quarter") != std::string::npos);
	}

	SECTION("Empty machine starts in SoldOutState")
	{
		GumballMachine machine(0);
		auto output = machine.ToString();

		REQUIRE(output.find("Inventory: 0 gumballs") != std::string::npos);
		REQUIRE(output.find("0 gumball") != std::string::npos);
		REQUIRE(output.find("gumballs") != std::string::npos);
	}

	SECTION("Machine with 1 ball uses singular form")
	{
		GumballMachine machine(1);
		auto output = machine.ToString();

		REQUIRE(output.find("Inventory: 1 gumball") != std::string::npos);
		REQUIRE(output.find("1 gumballs") == std::string::npos);
		REQUIRE(output.find("Machine is waiting for quarter") != std::string::npos);
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

		REQUIRE((output.find("You haven't inserted a quarter") != std::string::npos || output.find("haven't inserted") != std::string::npos));
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

		REQUIRE((output.find("You need to pay first") != std::string::npos || output.find("No gumball dispensed") != std::string::npos));
	}
}

TEST_CASE("HasQuarterState behavior")
{
	GumballMachine machine(10);
	OutputCapture capture;

	machine.InsertQuarter();
	capture.Clear();

	SECTION("Insert multiple quarters in HasQuarterState")
	{
		for (int i = 0; i < 3; i++)
		{
			machine.InsertQuarter();
		}
		auto output = capture.GetOutput();

		REQUIRE(output.find("You inserted a quarter. Total quarters:") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		output = capture.GetOutput();
		REQUIRE(output.find("You inserted a quarter. Total quarters: 5") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		output = capture.GetOutput();
		bool hasError = output.find("You can't insert another quarter") != std::string::npos || output.find("can't insert") != std::string::npos || output.find("cannot insert") != std::string::npos || output.find("maximum") != std::string::npos;
		REQUIRE(hasError);
	}

	SECTION("Eject quarter in HasQuarterState returns all quarters")
	{
		machine.InsertQuarter();
		machine.InsertQuarter();
		capture.Clear();

		machine.EjectQuarter();
		auto output = capture.GetOutput();
		capture.Clear();
		machine.EjectQuarter();
		output = capture.GetOutput();
		REQUIRE((output.find("You haven't inserted a quarter") != std::string::npos || output.find("haven't inserted") != std::string::npos));
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
	SECTION("Dispense transitions based on remaining quarters and balls")
	{
		GumballMachine machine(3);
		OutputCapture capture;

		machine.InsertQuarter();
		machine.InsertQuarter();
		capture.Clear();
		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("A gumball comes rolling out the slot...") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		output = capture.GetOutput();
		REQUIRE(output.find("You inserted a quarter") != std::string::npos);
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
		REQUIRE((output.find("You can't insert a quarter, the machine is sold out") != std::string::npos || output.find("can't insert a quarter") != std::string::npos));
	}

	SECTION("SoldOutState with remaining quarters allows ejection")
	{
		GumballMachine machine(1);
		OutputCapture capture;

		machine.InsertQuarter();
		machine.InsertQuarter();
		machine.InsertQuarter();
		capture.Clear();

		machine.TurnCrank();
		auto output = capture.GetOutput();
		REQUIRE(output.find("Oops, out of gumballs") != std::string::npos);

		capture.Clear();
		machine.EjectQuarter();
		output = capture.GetOutput();
		REQUIRE(output.find("quarter(s) returned") != std::string::npos);
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

		REQUIRE((output.find("You can't insert a quarter, the machine is sold out") != std::string::npos || output.find("can't insert a quarter") != std::string::npos));
	}

	SECTION("Eject quarter in SoldOutState when no quarters")
	{
		GumballMachine machine(0);
		OutputCapture capture;

		machine.EjectQuarter();
		auto output = capture.GetOutput();

		REQUIRE((output.find("You can't eject, you haven't inserted a quarter yet") != std::string::npos || output.find("haven't inserted a quarter") != std::string::npos));
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
		machine.InsertQuarter();

		capture.Clear();
		machine.EjectQuarter();

		capture.Clear();
		machine.TurnCrank();
		REQUIRE(capture.GetOutput().find("You turned but there's no quarter") != std::string::npos);
	}

	SECTION("Sell all gumballs with multiple quarters")
	{
		GumballMachine machine(2);
		OutputCapture capture;

		machine.InsertQuarter();
		machine.InsertQuarter();
		machine.InsertQuarter();
		capture.Clear();
		machine.TurnCrank();
		auto output = capture.GetOutput();
		REQUIRE(output.find("A gumball comes rolling out the slot...") != std::string::npos);

		capture.Clear();
		machine.TurnCrank();
		output = capture.GetOutput();
		REQUIRE(output.find("A gumball comes rolling out the slot...") != std::string::npos);
		REQUIRE(output.find("Oops, out of gumballs") != std::string::npos);

		REQUIRE(machine.ToString().find("Inventory: 0 gumballs") != std::string::npos);
		REQUIRE(machine.ToString().find("sold out") != std::string::npos);


		capture.Clear();
		machine.EjectQuarter();
		REQUIRE(capture.GetOutput().find("quarter(s) returned") != std::string::npos);
	}

	SECTION("Multiple operations in different states")
	{
		GumballMachine machine(10);
		OutputCapture capture;

		machine.EjectQuarter();
		REQUIRE((capture.GetOutput().find("You haven't inserted a quarter") != std::string::npos || capture.GetOutput().find("haven't inserted") != std::string::npos));

		capture.Clear();
		machine.InsertQuarter();
		REQUIRE(capture.GetOutput().find("You inserted a quarter") != std::string::npos);

		capture.Clear();
		for (int i = 0; i < 4; i++)
		{
			machine.InsertQuarter();
		}
		auto output = capture.GetOutput();
		REQUIRE(output.find("You inserted a quarter. Total quarters: 5") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		output = capture.GetOutput();
		bool hasError = output.find("You can't insert another quarter") != std::string::npos || output.find("can't insert") != std::string::npos || output.find("cannot insert") != std::string::npos;
		REQUIRE(hasError);

		capture.Clear();
		machine.EjectQuarter();

		capture.Clear();
		machine.InsertQuarter();
		REQUIRE(capture.GetOutput().find("You inserted a quarter") != std::string::npos);

		capture.Clear();
		machine.TurnCrank();
		REQUIRE(capture.GetOutput().find("A gumball comes rolling out the slot...") != std::string::npos);

		REQUIRE(machine.ToString().find("Inventory: 9 gumballs") != std::string::npos);
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

		REQUIRE((output.find("You can't insert a quarter, the machine is sold out") != std::string::npos || output.find("can't insert a quarter") != std::string::npos));
	}

	SECTION("Eject from empty machine")
	{
		GumballMachine machine(0);
		OutputCapture capture;

		machine.EjectQuarter();
		auto output = capture.GetOutput();

		REQUIRE((output.find("You can't eject, you haven't inserted a quarter yet") != std::string::npos || output.find("haven't inserted a quarter") != std::string::npos));
	}

	SECTION("Turn crank on empty machine")
	{
		GumballMachine machine(0);
		OutputCapture capture;

		machine.TurnCrank();
		auto output = capture.GetOutput();

		REQUIRE(output.find("You turned but there's no gumballs") != std::string::npos);
	}

	SECTION("Try to operate after machine is empty but with quarters left")
	{
		GumballMachine machine(1);
		OutputCapture capture;

		machine.InsertQuarter();
		machine.InsertQuarter();
		machine.InsertQuarter();
		capture.Clear();

		machine.TurnCrank();
		auto output = capture.GetOutput();
		REQUIRE(output.find("Oops, out of gumballs") != std::string::npos);

		capture.Clear();
		machine.InsertQuarter();
		output = capture.GetOutput();
		bool cannotInsert = output.find("You can't insert a quarter, the machine is sold out") != std::string::npos || output.find("can't insert a quarter") != std::string::npos;
		REQUIRE(cannotInsert);

		capture.Clear();
		machine.EjectQuarter();
		output = capture.GetOutput();
		REQUIRE(output.find("quarter(s) returned") != std::string::npos);

		capture.Clear();
		machine.TurnCrank();
		REQUIRE(capture.GetOutput().find("You turned but there's no gumballs") != std::string::npos);
	}

	SECTION("Max quarters functionality")
	{
		GumballMachine machine(10);
		OutputCapture capture;

		for (int i = 0; i < 5; i++)
		{
			machine.InsertQuarter();
		}


		for (int i = 0; i < 3; i++)
		{
			capture.Clear();
			machine.TurnCrank();
			REQUIRE(capture.GetOutput().find("A gumball comes rolling out the slot...") != std::string::npos);
		}
		REQUIRE(machine.ToString().find("Inventory: 7 gumballs") != std::string::npos);
	}
}


TEST_CASE("Refill functionality")
{
    SECTION("Refill empty machine")
    {
        GumballMachine machine(0);
        OutputCapture capture;

        machine.Refill(5);
        auto output = capture.GetOutput();

        REQUIRE(output.find("Machine refilled with 5 gumball(s)") != std::string::npos);
        REQUIRE(machine.ToString().find("Inventory: 5 gumballs") != std::string::npos);
        REQUIRE(machine.ToString().find("waiting for quarter") != std::string::npos);
    }

    SECTION("Refill machine with quarters")
    {
        GumballMachine machine(2);
        OutputCapture capture;

        machine.InsertQuarter();
        machine.InsertQuarter();
        machine.InsertQuarter();

        capture.Clear();
        machine.Refill(3);
        auto output = capture.GetOutput();

        REQUIRE(output.find("Machine refilled with 3 gumball(s)") != std::string::npos);
    }

    SECTION("Refill machine at max quarters")
    {
        GumballMachine machine(1);
        OutputCapture capture;

        for (int i = 0; i < 5; i++)
        {
            machine.InsertQuarter();
        }

        capture.Clear();
        machine.Refill(4);
        auto output = capture.GetOutput();

        REQUIRE(output.find("Machine refilled with 4 gumball(s)") != std::string::npos);
        REQUIRE(machine.ToString().find("Inventory: 5 gumballs") != std::string::npos);
    }

    SECTION("Cannot refill while dispensing")
    {
        GumballMachine machine(2);
        OutputCapture capture;

        machine.InsertQuarter();
        machine.TurnCrank();

        capture.Clear();
        machine.Refill(3);
        auto output = capture.GetOutput();

        machine.TurnCrank();

        REQUIRE(machine.ToString().find("waiting for quarter") != std::string::npos);
    }

    SECTION("Refill from sold out with quarters")
    {
        GumballMachine machine(1);
        OutputCapture capture;

        machine.InsertQuarter();
        machine.InsertQuarter();
        machine.InsertQuarter();
        machine.TurnCrank();

        REQUIRE(machine.ToString().find("Inventory: 0 gumballs") != std::string::npos);
        REQUIRE(machine.ToString().find("sold out") != std::string::npos);

        capture.Clear();
        machine.Refill(5);
        auto output = capture.GetOutput();

        REQUIRE(output.find("Machine refilled with 5 gumball(s)") != std::string::npos);
    }
}