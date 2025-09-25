#pragma once

#include "Data/WeatherInfo.h"

struct WeatherInfoPro : public WeatherInfo
{
	double windSpeed = 0;
	int windDirection = 0;
};