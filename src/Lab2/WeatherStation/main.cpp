#include "Observable/WeatherData.h"
#include "Observer/Base/Display.h"
#include "Observer/Base/StatsDisplay.h"

int main()
{
	try
	{
		WeatherData inWeatherData;
		WeatherData outWeatherData;

		Display<WeatherData> display(inWeatherData, outWeatherData);
		inWeatherData.RegisterObserver(display, 100);

		StatsDisplay<WeatherData> statsDisplay(inWeatherData, outWeatherData);
		inWeatherData.RegisterObserver(statsDisplay, 1);

		inWeatherData.SetMeasurements(3, 0.7, 760);
		inWeatherData.SetMeasurements(4, 0.8, 761);

		inWeatherData.RemoveObserver(statsDisplay);

		inWeatherData.SetMeasurements(10, 0.8, 761);
		inWeatherData.SetMeasurements(-10, 0.8, 761);
	}
	catch (const std::exception& exception)
	{
		std::cout << exception.what() << std::endl;
		return 1;
	}
	return 0;
}