#include "../../../src/Lab3/Stream/Input/FileInputStream.h"
#include <catch2/catch_all.hpp>


TEST_CASE("ReadByte from empty stream")
{
	std::istringstream emptyStream("");
	FileInputStream input(emptyStream);

	REQUIRE(input.IsEOF() == true);

	REQUIRE_THROWS_AS(input.ReadByte(), std::exception);
}

TEST_CASE("ReadByte from non-empty stream")
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


TEST_CASE("FileInputStream - ReadBlock from empty stream")
{
	std::istringstream emptyStream("");
	FileInputStream input(emptyStream);

	char buffer[10];
	const std::streamsize result = input.ReadBlock(buffer, 10);

	REQUIRE(result == 0);
	REQUIRE(input.IsEOF());
}

TEST_CASE("ReadBlock with exact size")
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

TEST_CASE("FileInputStream - ReadBlock with null buffer", "[FileInputStream]")
{
	std::string testData = "Hello";
	std::istringstream stream(testData);
	FileInputStream input(stream);

	REQUIRE_THROWS(input.ReadBlock(nullptr, 5));

	std::streamsize result = input.ReadBlock(nullptr, 0);
	REQUIRE(result == 0);
}

TEST_CASE("IsEOF behavior")
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