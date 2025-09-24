#include "MockPriorityObserver2.h"

MockPriorityObserver2::MockPriorityObserver2(std::vector<int>& order)
	: m_executionOrder(order)
{
}


void MockPriorityObserver2::Update(const WeatherInfo& data)
{
	m_executionOrder.push_back(2);
}