#include "Observable/WeatherData.h"
#include "Observer/Display.h"
#include "Observer/StatsDisplay.h"

int main()
{
	try
	{
		WeatherData weatherData;

		Display display;
		weatherData.RegisterObserver(display, 100);

		StatsDisplay statsDisplay;
		weatherData.RegisterObserver(statsDisplay, 1);

		weatherData.SetMeasurements(3, 0.7, 760);
		weatherData.SetMeasurements(4, 0.8, 761);

		weatherData.RemoveObserver(statsDisplay);

		weatherData.SetMeasurements(10, 0.8, 761);
		weatherData.SetMeasurements(-10, 0.8, 761);
	}
	catch (const std::exception& exception)
	{
		std::cout << exception.what() << std::endl;
		return 1;
	}
	return 0;
}