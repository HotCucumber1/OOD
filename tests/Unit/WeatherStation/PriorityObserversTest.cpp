#include "../../../src/Lab2/WeatherStation/Observable/WeatherData.h"
#include "../../../src/Lab2/WeatherStation/Observer/Display.h"
#include "Mock/MockObserver.h"
#include "Mock/MockPriorityObserver1.h"
#include "Mock/MockPriorityObserver2.h"
#include <catch2/catch_all.hpp>

TEST_CASE("Test register observer")
{
	SECTION("Test registry non existed observer success")
	{
		WeatherData weatherData;
		MockObserver observer;

		weatherData.RegisterObserver(observer, 100);
		REQUIRE(observer.GetCalls() == 0);
		weatherData.SetMeasurements(3, 0.7, 760);
		REQUIRE(observer.GetCalls() == 1);
	}

	SECTION("Test registry existed observer fail")
	{
		WeatherData weatherData;
		MockObserver observer;

		weatherData.RegisterObserver(observer, 100);
		REQUIRE(observer.GetCalls() == 0);
		REQUIRE_THROWS(weatherData.RegisterObserver(observer, 100));
	}
}

TEST_CASE("Test remover observer")
{
	SECTION("Test remove existed observer success")
	{
		WeatherData weatherData;
		MockObserver observer;

		weatherData.RegisterObserver(observer, 100);
		REQUIRE(observer.GetCalls() == 0);
		weatherData.RemoveObserver(observer);
		REQUIRE(true);
	}

	SECTION("Test remove non existed observer fail")
	{
		WeatherData weatherData;
		MockObserver observer;

		REQUIRE_THROWS(weatherData.RemoveObserver(observer));
	}
}

TEST_CASE("Test observer priority")
{
	SECTION("Test remove existed observer success")
	{
		std::vector<int> executionOrder;

		WeatherData weatherData;
		MockPriorityObserver1 observer1(executionOrder);
		MockPriorityObserver2 observer2(executionOrder);

		weatherData.RegisterObserver(observer1, 2);
		weatherData.RegisterObserver(observer2, 1);

		weatherData.SetMeasurements(3, 0.7, 760);

		REQUIRE(executionOrder[0] == 1);
		REQUIRE(executionOrder[1] == 2);
	}
}