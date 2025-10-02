#include "../../../src/Lab3/Stream/Input/FileInputStream.h"
#include "../../../src/Lab3/Stream/Output/FileOutputStream.h"
#include <catch2/catch_all.hpp>


TEST_CASE("Input stream")
{
	SECTION("ReadByte from empty stream")
	{
		std::istringstream emptyStream("");
		FileInputStream input(emptyStream);

		REQUIRE(input.IsEOF() == true);

		REQUIRE_THROWS_AS(input.ReadByte(), std::exception);
	}

	SECTION("ReadByte from non-empty stream")
	{
		std::string testData = "Hello";
		std::istringstream stream(testData);
		FileInputStream input(stream);

		REQUIRE(!input.IsEOF());

		REQUIRE(input.ReadByte() == 'H');
		REQUIRE(input.ReadByte() == 'e');
		REQUIRE(input.ReadByte() == 'l');
		REQUIRE(input.ReadByte() == 'l');
		REQUIRE(input.ReadByte() == 'o');

		REQUIRE(input.IsEOF());
		REQUIRE_THROWS_AS(input.ReadByte(), std::exception);
	}


	SECTION("FileInputStream - ReadBlock from empty stream")
	{
		std::istringstream emptyStream("");
		FileInputStream input(emptyStream);

		char buffer[10];
		const std::streamsize result = input.ReadBlock(buffer, 10);

		REQUIRE(result == 0);
		REQUIRE(input.IsEOF());
	}

	SECTION("ReadBlock with exact size")
	{
		std::string testData = "HelloWorld";
		std::istringstream stream(testData);
		FileInputStream input(stream);

		char buffer[10];
		std::streamsize result = input.ReadBlock(buffer, 10);

		REQUIRE(result == 10);
		REQUIRE(std::string(buffer, 10) == "HelloWorld");
		REQUIRE(input.IsEOF());
	}

	SECTION("FileInputStream - ReadBlock with null buffer", "[FileInputStream]")
	{
		std::string testData = "Hello";
		std::istringstream stream(testData);
		FileInputStream input(stream);

		REQUIRE_THROWS(input.ReadBlock(nullptr, 5));

		std::streamsize result = input.ReadBlock(nullptr, 0);
		REQUIRE(result == 0);
	}

	SECTION("IsEOF behavior")
	{
		std::string testData = "AB";
		std::istringstream stream(testData);
		FileInputStream input(stream);

		REQUIRE(input.IsEOF() == false);

		REQUIRE(input.ReadByte() == 'A');
		REQUIRE(input.IsEOF() == false);

		REQUIRE(input.ReadByte() == 'B');
		REQUIRE(input.IsEOF() == true);
	}
}

TEST_CASE("Output stream")
{
    std::ostringstream stream;
    FileOutputStream output(stream);

    SECTION("Write single bytes")
    {
        output.WriteByte('H');
        output.WriteByte('e');
        output.WriteByte('l');
        output.WriteByte('l');
        output.WriteByte('o');

        output.Close();
        REQUIRE(stream.str() == "Hello");
    }

	SECTION("Write block with exact data")
    {
    	std::string data = "HelloWorld";
    	output.WriteBlock(data.data(), data.size());
    	output.Close();

    	REQUIRE(stream.str() == "HelloWorld");
    }

	SECTION("Write multiple blocks")
    {
    	std::string part1 = "Hello";
    	std::string part2 = "World";
    	std::string part3 = "Test";

    	output.WriteBlock(part1.data(), part1.size());
    	output.WriteBlock(part2.data(), part2.size());
    	output.WriteBlock(part3.data(), part3.size());
    	output.Close();

    	REQUIRE(stream.str() == "HelloWorldTest");
    }

	SECTION("Write empty block")
    {
    	std::string data = "Hello";
    	output.WriteBlock(data.data(), 0);
    	output.WriteBlock(data.data(), data.size());
    	output.Close();

    	REQUIRE(stream.str() == "Hello");
    }

	SECTION("Null buffer with positive size ")
    {
    	REQUIRE_THROWS_AS(output.WriteBlock(nullptr, 5), std::exception);

    	std::string data = "Test";
    	output.WriteBlock(data.data(), data.size());
    	output.Close();
    	REQUIRE(stream.str() == "Test");
    }

	SECTION("Null buffer with zero size is allowed")
    {
    	output.WriteBlock(nullptr, 0);

    	std::string data = "Data";
    	output.WriteBlock(data.data(), data.size());
    	output.Close();
    	REQUIRE(stream.str() == "Data");
    }

	SECTION("Close after writes")
    {
    	FileOutputStream output(stream);
    	output.WriteByte('A');
    	output.WriteByte('B');
    	output.Close();

    	REQUIRE(stream.str() == "AB");

    	output.Close();
    	REQUIRE(stream.str() == "AB");
    }

	SECTION("Close without writes")
    {
    	FileOutputStream output(stream);
    	output.Close();

    	REQUIRE(stream.str().empty());
    }

	SECTION("Write after close should throw")
    {
    	FileOutputStream output(stream);
    	output.WriteByte('X');
    	output.Close();

    	REQUIRE_THROWS_AS(output.WriteByte('Y'), std::exception);
    	REQUIRE_THROWS_AS(output.WriteBlock("test", 4), std::exception);

    	REQUIRE(stream.str() == "X");
    }

	SECTION("Write to bad stream throws")
    {
    	FileOutputStream output(stream);

    	stream.setstate(std::ios::badbit);

    	REQUIRE_THROWS_AS(output.WriteByte('A'), std::exception);
    	REQUIRE_THROWS_AS(output.WriteBlock("test", 4), std::exception);
    }
}
