#pragma once
#include "WeatherDisplay.h"
#include <iostream>

template <typename ObservableT>
class Display : public WeatherDisplay<ObservableT>
{
public:
	Display(ObservableT& subject1, ObservableT& subject2)
		: WeatherDisplay<ObservableT>(subject1, subject2)
	{
	}

private:
	void Update(const WeatherInfo& data, const ObservableT& subj) override
	{
		std::cout << "Message from <" << this->GetSource(subj) << ">:" << std::endl;

		std::cout << "Current Temp " << data.temperature << std::endl;
		std::cout << "Current Hum " << data.humidity << std::endl;
		std::cout << "Current Pressure " << data.pressure << std::endl;
		std::cout << "----------------" << std::endl;
	}
};
