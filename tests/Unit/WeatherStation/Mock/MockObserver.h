#pragma once

#include "../../../../src/Lab2/WeatherStation/Data/WeatherInfo.h"
#include "../../../../src/Lab2/WeatherStation/Observer/ObserverInterface.h"

class MockObserver : public ObserverInterface<WeatherInfo>
{
public:
	void Update(const WeatherInfo& data) override;
	int GetCalls() const;

private:
	int m_calls = 0;
};
