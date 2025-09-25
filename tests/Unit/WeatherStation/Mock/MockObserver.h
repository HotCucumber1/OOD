#pragma once

#include "../../../../src/Lab2/WeatherStation/Data/WeatherInfo.h"
#include "../../../../src/Lab2/WeatherStation/Observer/ObserverInterface.h"

template <typename ObservableT>
class MockObserver : public ObserverInterface<WeatherInfo, ObservableT>
{
public:
	void Update(const WeatherInfo& data, const ObservableT& subj) override
	{
		++m_calls;
	}

	int GetCalls() const
	{
		return m_calls;
	}

private:
	int m_calls = 0;
};
