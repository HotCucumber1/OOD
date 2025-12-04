#include <catch2/catch_all.hpp>
#include "../../../src/Lab9/CopyOnWrite/Image/Tile.h"

TEST_CASE("Test constructor")
{
	SECTION("Success")
	{
		const Tile tile(10, 10, 'X');
		REQUIRE(tile.GetPixel(5, 5) == 'X');
	}

	SECTION("Zero")
	{
		const Tile tile(0, 0, 'X');
		REQUIRE(tile.GetPixel(5, 5) == ' ');
	}
}

TEST_CASE("Test set pixel")
{
	SECTION("Success")
	{
		Tile tile(10, 10, 'X');
		tile.SetPixel(5, 5, 'Y');
		REQUIRE(tile.GetPixel(5, 5) == 'Y');
	}

	SECTION("Fail")
	{
		Tile tile(10, 10, 'X');
		tile.SetPixel(15, 15, 'Y');
		REQUIRE(true);
	}
}

TEST_CASE("Test get pixel")
{
	SECTION("Success")
	{
		Tile tile(10, 10, 'X');
		tile.SetPixel(5, 5, 'Y');
		REQUIRE(tile.GetPixel(5, 5) == 'Y');
	}

	SECTION("Fail")
	{
		Tile tile(10, 10, 'X');
		tile.SetPixel(15, 15, 'Y');
		REQUIRE(tile.GetPixel(15, 15) == ' ');
	}
}

TEST_CASE("Test tile counter")
{
	REQUIRE(Tile::GetInstanceCount() == 0);
	Tile tile1(10, 10, 'X');
	Tile tile2(11, 11, 'X');
	Tile tile3(12, 13, 'X');
	REQUIRE(Tile::GetInstanceCount() == 3);
}