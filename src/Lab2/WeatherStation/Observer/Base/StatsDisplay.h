#pragma once

#include "../../Data/Statistics.h"
#include "WeatherDisplay.h"
#include <iostream>
#include <vector>

template <typename ObservableT>
class StatsDisplay : public WeatherDisplay<ObservableT>
{
public:
	StatsDisplay(ObservableT& subject1, ObservableT& subject2)
		: WeatherDisplay<ObservableT>(subject1, subject2)
	{
		m_params.emplace_back("Temp");
		m_params.emplace_back("Hum");
		m_params.emplace_back("Press");
	}

private:
	void Update(const WeatherInfo& data, const ObservableT& subj) override
	{
		m_params[0].Update(data.temperature);
		m_params[1].Update(data.humidity);
		m_params[2].Update(data.pressure);

		for (const auto& param : m_params)
		{
			std::cout << "Message from <" << this->GetSource(subj) << ">:" << std::endl;
			param.PrintInfo();
		}
	}

private:
	std::vector<Statistics> m_params;
};
