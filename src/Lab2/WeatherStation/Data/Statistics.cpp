#include "Statistics.h"

#include <iostream>

Statistics::Statistics(std::string name)
	: m_name(std::move(name))
{
}

void Statistics::Update(double newValue)
{
	if (m_minValue > newValue)
	{
		m_minValue = newValue;
	}
	if (m_maxValue < newValue)
	{
		m_maxValue = newValue;
	}
	m_accValue += newValue;
	++m_count;
}

void Statistics::PrintInfo() const
{
	std::cout << "Max " << m_name << ' ' << m_maxValue << std::endl;
	std::cout << "Min " << m_name << ' ' << m_minValue << std::endl;
	std::cout << "Average " << m_name << ' ' << (m_accValue / m_count) << std::endl;
	std::cout << "----------------" << std::endl;
}
