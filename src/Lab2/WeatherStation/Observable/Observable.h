#pragma once

#include "ObservableInterface.h"
#include <algorithm>
#include <iostream>
#include <unordered_map>
#include <unordered_set>
#include <vector>

template<typename T, typename Derived, typename EventType = DefaultEvent>
class Observable : public ObservableInterface<T, Derived, EventType>
{
public:
	using ObserverType = ObserverInterface<T, Derived>;

	void RegisterObserver(ObserverType& observer, int priority, EventType eventType = EventType{}) override
	{
		if (m_observers.find(&observer) != m_observers.end() &&
			m_observers[&observer].second.find(eventType) == m_observers[&observer].second.end())
		{
			m_observers[&observer].second.insert(eventType);
			return;
		}

		ObserverInfo info = std::make_pair(priority, std::unordered_set<EventType>{eventType});
		auto it = m_observers.try_emplace(&observer, info);
		if (!it.second)
		{
			throw std::runtime_error("Observer with this priority already specified");
		}
	}

	void NotifyObservers(EventType eventType = EventType{}) override
	{
		T data = GetChangedData();
		std::vector<std::pair<ObserverType*, ObserverInfo>> prioritizedObservers(m_observers.begin(), m_observers.end());
		
		std::sort(prioritizedObservers.begin(), prioritizedObservers.end(), [](auto& a, auto& b) {
			return a.second.first > b.second.first;
		});

		for (auto& observer : prioritizedObservers)
		{
			if (observer.second.second.find(eventType) != observer.second.second.end())
			{
				observer.first->Update(data, GetDerived());
			}
		}
	}

	void RemoveObserver(ObserverType& observer, EventType eventType = EventType{}) override
	{
		if (m_observers.find(&observer) == m_observers.end())
		{
			throw std::runtime_error("Observer not exist");
		}
		m_observers[&observer].second.erase(eventType);
		if (m_observers[&observer].second.empty())
		{
			m_observers.erase(&observer);
		}
	}

	Derived& GetDerived()
	{
		return static_cast<Derived&>(*this);
	}

protected:
	virtual T GetChangedData() const = 0;

private:
	using ObserverInfo = std::pair<int, std::unordered_set<EventType>>;
	std::unordered_map<ObserverType*, ObserverInfo> m_observers;
};
