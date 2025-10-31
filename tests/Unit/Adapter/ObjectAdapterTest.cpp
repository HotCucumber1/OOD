#include "../../../src/Lab6/ModernGraphicsLib.h"
#include "../../../src/Lab6/ObjectAdapter/RendererToCanvasAdapter.h"

#include <catch2/catch_all.hpp>

TEST_CASE("Test adapter")
{
	SECTION("Draw lines")
	{
		std::ostringstream output;

		{
			modern_graphics_lib::CModernGraphicsRenderer renderer(output);
			RendererToCanvasAdapter adapter(renderer);

			adapter.MoveTo(10, 10);
			adapter.LineTo(20, 20);
			adapter.LineTo(30, 10);
			adapter.LineTo(10, 10);
		}
		std::string expected = R"(<draw>
  <line fromX="10" fromY="10" toX="20" toY="20"/>
  <line fromX="20" fromY="20" toX="30" toY="10"/>
  <line fromX="30" fromY="10" toX="10" toY="10"/>
</draw>
)";
		REQUIRE(output.str() == expected);
	}

	SECTION("Draw nothing")
	{
		std::ostringstream output;

		{
			modern_graphics_lib::CModernGraphicsRenderer renderer(output);
			RendererToCanvasAdapter adapter(renderer);
		}

		std::string expected = R"(<draw>
</draw>
)";
		REQUIRE(output.str() == expected);
	}

}