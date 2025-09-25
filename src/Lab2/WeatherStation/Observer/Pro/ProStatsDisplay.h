#pragma once

#include "../../Data/ProStatistics.h"
#include "../../Data/Statistics.h"
#include "ProWeatherDisplay.h"
#include <iostream>
#include <vector>

template <typename ObservableT>
class ProStatsDisplay : public ProWeatherDisplay<ObservableT>
{
public:
	ProStatsDisplay(ObservableT& subject1, ObservableT& subject2)
		: ProWeatherDisplay<ObservableT>(subject1, subject2)
	{
		m_params.emplace_back("Temp");
		m_params.emplace_back("Hum");
		m_params.emplace_back("Press");
		m_params.emplace_back("Wind speed");
	}

private:
	void Update(const WeatherInfoPro& data, const ObservableT& subj) override
	{
		m_params[0].Update(data.temperature);
		m_params[1].Update(data.humidity);
		m_params[2].Update(data.pressure);
		m_params[3].Update(data.windSpeed);

		m_windParam.Update(data.windDirection);

		for (const auto& param : m_params)
		{
			std::cout << "Message from <" << this->GetSource(subj) << ">:" << std::endl;
			param.PrintInfo();
		}
		m_windParam.PrintInfo();
		std::cout << "----------------" << std::endl;
	}

private:
	std::vector<Statistics> m_params;
	ProStatistics m_windParam{"Wind direction"};
};
