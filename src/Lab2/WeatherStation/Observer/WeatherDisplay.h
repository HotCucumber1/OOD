#pragma once

#include "../Data/WeatherInfo.h"
#include "ObserverInterface.h"
#include <string>

template <typename ObservableT>
class WeatherDisplay : public ObserverInterface<WeatherInfo, ObservableT>
{
public:
	WeatherDisplay(ObservableT& subject1, ObservableT& subject2)
		: m_inSubject(subject1)
		, m_outSubject(subject2)
	{
	}

protected:
	std::string GetSource(const ObservableT& subj)
	{
		std::string source;
		if (&m_inSubject == &subj)
		{
			source = "In-station";
		}
		else if (&m_outSubject == &subj)
		{
			source = "Out-station";
		}
		else
		{
			throw std::runtime_error("Observable subject not found");
		}
		return source;
	}

protected:
	ObservableT& m_inSubject;
	ObservableT& m_outSubject;
};