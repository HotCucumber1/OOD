#pragma once

#include "../Data/Statistics.h"
#include "../Data/WeatherInfo.h"
#include "ObserverInterface.h"
#include <vector>

class StatsDisplay : public ObserverInterface<WeatherInfo>
{
public:
	StatsDisplay();

private:
	void Update(const WeatherInfo& data) override;

private:
	std::vector<Statistics> m_params;
};
