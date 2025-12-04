#include <catch2/catch_all.hpp>
#include "../../../src/Lab9/CopyOnWrite/Image/Image.h"

TEST_CASE("Test constructor")
{
	SECTION("Success")
	{
		const Image image(20, 20);
		REQUIRE(image.GetPixel(10, 10) == Image::DEFAULT_COLOR);
		REQUIRE(Tile::GetInstanceCount() == 4);
	}

	SECTION("Zero")
	{
		const Image image(0, 0);
		REQUIRE(image.GetPixel(5, 5) == ' ');
		REQUIRE(Tile::GetInstanceCount() == 0);
	}

	SECTION("Non smooth tiles")
	{
		const Image image(12, 12);
		REQUIRE(Tile::GetInstanceCount() == 4);
	}
}

TEST_CASE("Test get pixel")
{
	SECTION("Success")
	{
		const Image image(20, 20);
		REQUIRE(image.GetPixel(0, 0) == Image::DEFAULT_COLOR);
	}

	SECTION("Fail")
	{
		const Image image(20, 20);
		REQUIRE(image.GetPixel(25, 13) == ' ');
	}
}


TEST_CASE("Test set pixel")
{
	SECTION("Success")
	{
		Image image(20, 20);
		image.SetPixel(10, 11, 'Z');
		REQUIRE(image.GetPixel(10, 11) == 'Z');
	}

	SECTION("Fail")
	{
		Image image(20, 20);
		image.SetPixel(100, 11, 'Z');
		REQUIRE(image.GetPixel(100, 11) == ' ');
	}
}