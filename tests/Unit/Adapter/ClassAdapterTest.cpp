#include "../../../src/Lab6/ModernGraphicsLib.h"
#include "../../../src/Lab6/ClassAdapter/RendererToCanvasAdapter.h"

#include <catch2/catch_all.hpp>

TEST_CASE("Test adapter")
{
	SECTION("Draw lines")
	{
		std::ostringstream output;

		{
			RendererToCanvasAdapter adapter(output);

			adapter.MoveTo(10, 10);
			adapter.LineTo(20, 20);
			adapter.LineTo(30, 10);
			adapter.LineTo(10, 10);
		}
		std::string expected = R"(<draw>
  <line fromX="10" fromY="10" toX="20" toY="20">
    <color r="0.00" g="0.00" b="0.00" a="0.00">
  </line>
  <line fromX="20" fromY="20" toX="30" toY="10">
    <color r="0.00" g="0.00" b="0.00" a="0.00">
  </line>
  <line fromX="30" fromY="10" toX="10" toY="10">
    <color r="0.00" g="0.00" b="0.00" a="0.00">
  </line>
</draw>
)";
		REQUIRE(output.str() == expected);
	}

	SECTION("Draw nothing")
	{
		std::ostringstream output;

		{
			RendererToCanvasAdapter adapter(output);
		}

		std::string expected = R"(<draw>
</draw>
)";
		REQUIRE(output.str() == expected);
	}

	SECTION("Set color")
	{
		std::ostringstream output;
		{
			RendererToCanvasAdapter adapter(output);

			adapter.MoveTo(10, 10);
			adapter.LineTo(20, 20);
			adapter.SetColor(0xFF804080);
			adapter.LineTo(30, 10);
		}

		std::string expected = R"(<draw>
  <line fromX="10" fromY="10" toX="20" toY="20">
    <color r="0.00" g="0.00" b="0.00" a="0.00">
  </line>
  <line fromX="20" fromY="20" toX="30" toY="10">
    <color r="1.00" g="0.50" b="0.25" a="0.50">
  </line>
</draw>
)";
		REQUIRE(output.str() == expected);
	}
}