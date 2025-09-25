#include "ObservableInterface.h"
#include <algorithm>
#include <memory>
#include <set>
#include <unordered_map>
#include <vector>

template <typename T, typename Derived>
class Observable : public ObservableInterface<T, Derived>
{
public:
	using ObserverType = ObserverInterface<T, Derived>;

	void RegisterObserver(ObserverType& observer, int priority) override
	{
		auto it = m_observers.try_emplace(&observer, priority);
		if (!it.second)
		{
			throw std::runtime_error("Observer with this priority already specified");
		}
	}

	void NotifyObservers() override
	{
		T data = GetChangedData();
		std::vector<std::pair<ObserverType*, int>> prioritizedObservers(m_observers.begin(), m_observers.end());
		
		std::sort(prioritizedObservers.begin(), prioritizedObservers.end(), [](auto& a, auto& b) {
			return a.second > b.second;
		});

		for (auto& observer : prioritizedObservers)
		{
			observer.first->Update(data, GetDerived());
		}
	}

	void RemoveObserver(ObserverType& observer) override
	{
		if (m_observers.find(&observer) == m_observers.end())
		{
			throw std::runtime_error("Observer not exist");
		}
		m_observers.erase(&observer);
	}

	Derived& GetDerived()
	{
		return static_cast<Derived&>(*this);
	}

protected:
	virtual T GetChangedData() const = 0;

private:
	std::unordered_map<ObserverType*, int> m_observers;
};
