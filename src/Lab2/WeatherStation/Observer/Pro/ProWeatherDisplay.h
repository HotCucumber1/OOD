#pragma once

#include "../../Data/WeatherInfo.h"
#include "../../WeatherInfoPro.h"
#include "../ObserverInterface.h"
#include <stdexcept>
#include <string>

template <typename ObservableT>
class ProWeatherDisplay : public ObserverInterface<WeatherInfoPro, ObservableT>
{
public:
	ProWeatherDisplay(ObservableT& subject1, ObservableT& subject2)
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