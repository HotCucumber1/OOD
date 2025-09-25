#pragma once

#include "../../../../src/Lab2/WeatherStation/Data/WeatherInfo.h"
#include "../../../../src/Lab2/WeatherStation/Observer/ObserverInterface.h"
#include <vector>

template<typename ObservableT>
class MockPriorityObserver2 : public ObserverInterface<WeatherInfo, ObservableT>
{
public:
	explicit MockPriorityObserver2(std::vector<int>& order)
		: m_executionOrder(order)
	{
	}

	void Update(const WeatherInfo& dat, const ObservableT& subj) override
	{
		m_executionOrder.push_back(2);
	}
private:
	std::vector<int>& m_executionOrder;
};
