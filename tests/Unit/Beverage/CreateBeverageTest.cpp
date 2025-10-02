#include "../../../src/Lab3/Beverage/Model/Beverages/Cappuccino.h"
#include "../../../src/Lab3/Beverage/Model/Beverages/Latte.h"
#include "../../../src/Lab3/Beverage/Model/Beverages/Tea.h"

#include "../../../src/Lab3/Beverage/Model/Condiments/ChocolateBar.h"
#include "../../../src/Lab3/Beverage/Model/Condiments/Cream.h"
#include "../../../src/Lab3/Beverage/Model/Condiments/Liquor.h"

#include "../../../src/Lab3/Beverage/Model/Size/DoubleCappuccino.h"
#include "../../../src/Lab3/Beverage/Model/Size/DoubleLatte.h"

#include "../../../src/Lab3/Beverage/Model/Type/DyanHunTea.h"
#include "../../../src/Lab3/Beverage/Model/Type/LyunCzinTea.h"
#include "../../../src/Lab3/Beverage/Model/Type/ShuPuerTea.h"
#include "../../../src/Lab3/Beverage/Model/Type/TeGuanyinTea.h"

#include <catch2/catch_all.hpp>

TEST_CASE("Create tea")
{
	SECTION("Test create Dyan hun tea success")
	{
		const auto tea = std::make_unique<DyanHunTea>(
			std::make_unique<Tea>());
		REQUIRE(tea->GetDescription() == "Tea Dyan hun");
	}

	SECTION("Test create Lyun czin tea success")
	{
		const auto tea = std::make_unique<LyunCzinTea>(
			std::make_unique<Tea>());
		REQUIRE(tea->GetDescription() == "Tea Lyun czin");
	}

	SECTION("Test create Shu puer success")
	{
		const auto tea = std::make_unique<ShuPuerTea>(
			std::make_unique<Tea>());
		REQUIRE(tea->GetDescription() == "Tea Shu puer");
	}

	SECTION("Test create Dyan hun tea success")
	{
		const auto tea = std::make_unique<TeGuanyinTea>(
			std::make_unique<Tea>());
		REQUIRE(tea->GetDescription() == "Tea Te guanyin");
	}
}

TEST_CASE("Create double portion")
{
	SECTION("Test create double latte success")
	{
		const auto coffee = std::make_unique<DoubleLatte>(
			std::make_unique<Latte>()
			);
		REQUIRE(coffee->GetDescription() == "Latte double");
	}

	SECTION("Test create double cappuccino success")
	{
		const auto coffee = std::make_unique<DoubleCappuccino>(
			std::make_unique<Cappuccino>()
			);
		REQUIRE(coffee->GetDescription() == "Cappuccino double");
	}
}

TEST_CASE("Create beverage with new condiment")
{
	SECTION("Test create with cream success")
	{
		const auto coffee = std::make_unique<Cream>(
			std::make_unique<Cappuccino>()
			);
		REQUIRE(coffee->GetDescription() == "Cappuccino, Cream");
	}

	SECTION("Test create with chocolate bar success")
	{
		const auto coffee = std::make_unique<ChocolateBar>(
			std::make_unique<Cappuccino>(), 3
			);
		REQUIRE(coffee->GetDescription() == "Cappuccino, Chocolate bar 3pieces");
	}

	SECTION("Test create with liquor success")
	{
		const auto coffee = std::make_unique<Liquor>(
			std::make_unique<Cappuccino>(), LiquorType::Nut
			);
		REQUIRE(coffee->GetDescription() == "Cappuccino, Nut liquor");
	}
}