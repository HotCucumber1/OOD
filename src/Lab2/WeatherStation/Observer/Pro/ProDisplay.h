#pragma once
#include "ProWeatherDisplay.h"
#include <iostream>

template <typename ObservableT>
class ProDisplay : public ProWeatherDisplay<ObservableT>
{
public:
	ProDisplay(ObservableT& subject1, ObservableT& subject2)
		: ProWeatherDisplay<ObservableT>(subject1, subject2)
	{
	}

private:
	void Update(const WeatherInfoPro& data, const ObservableT& subj) override
	{
		std::cout << "Message from <" << this->GetSource(subj) << ">:" << std::endl;

		std::cout << "Current Temp " << data.temperature << std::endl;
		std::cout << "Current Hum " << data.humidity << std::endl;
		std::cout << "Current Pressure " << data.pressure << std::endl;
		std::cout << "Current Wind speed " << data.windSpeed << std::endl;
		std::cout << "Current Wind direction " << data.windDirection << std::endl;
		std::cout << "----------------" << std::endl;
	}
};
