#pragma once
#include "../Observer/ObserverInterface.h"

enum DefaultEvent {};

template <typename T, typename Derived, typename EventType = DefaultEvent>
class ObservableInterface
{
public:
    virtual void RegisterObserver(
		ObserverInterface<T, Derived>& observer,
		int priority,
		EventType eventType = EventType{}) = 0;

    virtual void RemoveObserver(ObserverInterface<T, Derived>& observer, EventType eventType = EventType{}) = 0;

    virtual void NotifyObservers(EventType eventType = EventType{}) = 0;

    virtual ~ObservableInterface() = default;
};
