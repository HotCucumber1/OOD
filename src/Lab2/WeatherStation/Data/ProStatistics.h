#pragma once

#include "Statistics.h"
#include <vector>

class ProStatistics
{
public:
	explicit ProStatistics(std::string name);

	void Update(int newValue);

	void PrintInfo() const;

private:
	std::string m_name;
	std::vector<int> m_directions;
};
