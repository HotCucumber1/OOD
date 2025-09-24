#include "StatsDisplay.h"

StatsDisplay::StatsDisplay()
{
	m_params.emplace_back("Temp");
	m_params.emplace_back("Hum");
	m_params.emplace_back("Press");
}

void StatsDisplay::Update(const WeatherInfo& data)
{
	m_params[0].Update(data.temperature);
	m_params[1].Update(data.humidity);
	m_params[2].Update(data.pressure);

	for (const auto& param : m_params)
	{
		param.PrintInfo();
	}
}
