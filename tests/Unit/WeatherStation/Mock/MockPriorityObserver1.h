#pragma once

#include "../../../../src/Lab2/WeatherStation/Data/WeatherInfo.h"
#include "../../../../src/Lab2/WeatherStation/Observer/ObserverInterface.h"
#include <vector>

template <typename ObservableT>
class MockPriorityObserver1 : public ObserverInterface<WeatherInfo, ObservableT>
{
public:
	explicit MockPriorityObserver1(std::vector<int>& order)
		: m_executionOrder(order)
	{
	}

	void Update(const WeatherInfo& data, const ObservableT& subj) override
	{
		m_executionOrder.push_back(1);
	}
private:
	std::vector<int>& m_executionOrder;
};

