#pragma once

#include "../../../../src/Lab2/WeatherStation/Observer/WeatherDisplay.h"

template <typename ObservableT>
class MockMultyObserver : public WeatherDisplay<ObservableT>
{
public:
	MockMultyObserver(ObservableT& subject1, ObservableT& subject2)
		: WeatherDisplay<ObservableT>(subject1, subject2)
	{
	}

	int GetInCalls() const
	{
		return m_inCalls;
	}

	int GetOutCalls() const
	{
		return m_outCalls;
	}

private:
	void Update(const WeatherInfo& data, const ObservableT& subj) override
	{
		if (this->GetSource(subj) == "In-station")
		{
			++m_inCalls;
		}
		else if (this->GetSource(subj) == "Out-station")
		{
			++m_outCalls;
		}
	}

private:
	int m_inCalls = 0;
	int m_outCalls = 0;
};