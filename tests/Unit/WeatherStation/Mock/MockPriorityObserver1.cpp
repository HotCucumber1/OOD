#include "MockPriorityObserver1.h"

MockPriorityObserver1::MockPriorityObserver1(std::vector<int>& order)
	: m_executionOrder(order)
{
}


void MockPriorityObserver1::Update(const WeatherInfo& data)
{
	m_executionOrder.push_back(1);
}

