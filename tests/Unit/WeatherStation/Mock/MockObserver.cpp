#include "MockObserver.h"

void MockObserver::Update(const WeatherInfo& data)
{
	++m_calls;
}

int MockObserver::GetCalls() const
{
	return m_calls;
}
