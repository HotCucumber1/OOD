#include "ProStatistics.h"

#include <iostream>
#include <cmath>

const double M_PI_DEG = 180;
const double M_2_PI_DEG = 180;

double GetAvgDirection(const std::vector<int>& directions)
{
	double sumX = 0;
	double sumY = 0;

	for (const auto angle : directions)
	{
		double rad = angle * M_PI / M_PI_DEG;
		sumX += std::cos(rad);
		sumY += std::sin(rad);
	}

	double avgX = sumX / directions.size();
	double avgY = sumY / directions.size();

	double avgRad = std::atan2(avgY, avgX);
	double avgDeg = avgRad * M_PI_DEG / M_PI;

	if (avgDeg < 0)
	{
		avgDeg += M_2_PI_DEG * 2;
	}

	return avgDeg;
}

ProStatistics::ProStatistics(std::string name)
	: m_name(std::move(name))
{
}

void ProStatistics::Update(int newValue)
{
	m_directions.push_back(newValue);
}

void ProStatistics::PrintInfo() const
{
	auto avgDeg = GetAvgDirection(m_directions);
	std::cout << "Average " << m_name << ' ' << avgDeg << std::endl;
}
