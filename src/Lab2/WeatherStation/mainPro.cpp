#include "Observable/WeatherDataPro.h"
#include "Observer/Pro/ProDisplay.h"
#include "Observer/Pro/ProStatsDisplay.h"

int main()
{
	try
	{
		WeatherDataPro inWeatherData;
		WeatherDataPro outWeatherData;

		ProDisplay<WeatherDataPro> display(inWeatherData, outWeatherData);
		inWeatherData.RegisterObserver(display, 100);

		ProStatsDisplay<WeatherDataPro> statsDisplay(inWeatherData, outWeatherData);
		inWeatherData.RegisterObserver(statsDisplay, 1);

		inWeatherData.SetMeasurements(3, 0.7, 760, 200, 200);
		inWeatherData.SetMeasurements(4, 0.8, 761, 10, 10);

		inWeatherData.RemoveObserver(statsDisplay);

		inWeatherData.SetMeasurements(10, 0.8, 761, 100, 100);
		inWeatherData.SetMeasurements(-10, 0.8, 761, 10, 10);
	}
	catch (const std::exception& exception)
	{
		std::cout << exception.what() << std::endl;
		return 1;
	}
	return 0;
}