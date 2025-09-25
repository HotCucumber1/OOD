#include "../../../src/Lab2/WeatherStation/Observable/WeatherData.h"
#include "Mock/MockMultyObserver.h"
#include <catch2/catch_all.hpp>

TEST_CASE("Test different observers")
{
	SECTION("Test existed observable success")
	{
		WeatherData inStation;
		WeatherData outStation;

		MockMultyObserver<WeatherData> observer(inStation, outStation);

		inStation.RegisterObserver(observer, 1);
		outStation.RegisterObserver(observer, 1);

		inStation.SetMeasurements(3, 0.7, 760);
		REQUIRE(observer.GetInCalls() == 1);
		REQUIRE(observer.GetOutCalls() == 0);

		outStation.SetMeasurements(3, 0.7, 760);
		REQUIRE(observer.GetInCalls() == 1);
		REQUIRE(observer.GetOutCalls() == 1);
	}

	SECTION("Test non existed observable fail")
	{
		WeatherData inStation;
		WeatherData outStation;
		WeatherData anotherStation;

		MockMultyObserver<WeatherData> observer(inStation, outStation);

		inStation.RegisterObserver(observer, 1);
		outStation.RegisterObserver(observer, 1);
		anotherStation.RegisterObserver(observer, 1);

		REQUIRE_THROWS(anotherStation.SetMeasurements(3, 0.7, 760));
	}
}