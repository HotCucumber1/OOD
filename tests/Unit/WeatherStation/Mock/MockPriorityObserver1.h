#pragma once

#include "../../../../src/Lab2/WeatherStation/Data/WeatherInfo.h"
#include "../../../../src/Lab2/WeatherStation/Observer/ObserverInterface.h"
#include <vector>

class MockPriorityObserver1 : public ObserverInterface<WeatherInfo>
{
public:
	explicit MockPriorityObserver1(std::vector<int>& order);
	void Update(const WeatherInfo& data) override;
private:
	std::vector<int>& m_executionOrder;
};

